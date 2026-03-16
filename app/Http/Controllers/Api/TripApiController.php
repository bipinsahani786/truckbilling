<?php

namespace App\Http\Controllers\Api;

use App\Models\Trip;
use App\Services\TripService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class TripApiController extends BaseController
{
    protected TripService $tripService;

    public function __construct(TripService $tripService)
    {
        $this->tripService = $tripService;
    }

    #[OA\Get(
        path: '/api/trips',
        tags: ['Trips'],
        summary: 'Get all trips',
        description: "Retrieve a paginated list of trips based on the authenticated user's role.",
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', description: 'Search by location, truck, or ID', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'from_date', in: 'query', description: 'Start date (YYYY-MM-DD)', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'to_date', in: 'query', description: 'End date (YYYY-MM-DD)', required: false, schema: new OA\Schema(type: 'string', format: 'date'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Trips retrieved successfully')
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        
        $ownerId = $user->hasRole('owner') ? $user->id : $user->owner_id;
        $driverId = $user->hasRole('driver') ? $user->id : null;

        $trips = $this->tripService->getFilteredTrips(
            $ownerId,
            $driverId,
            $request->query('search'),
            $request->query('from_date'),
            $request->query('to_date')
        );

        return $this->sendResponse($trips, 'Trips retrieved successfully.');
    }

    #[OA\Post(
        path: '/api/trips',
        tags: ['Trips'],
        summary: 'Create a new trip',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['vehicle_id', 'driver_id', 'from_location', 'to_location', 'start_date'],
                properties: [
                    new OA\Property(property: 'vehicle_id', type: 'integer', example: 1),
                    new OA\Property(property: 'driver_id', type: 'integer', example: 2),
                    new OA\Property(property: 'dealer_id', type: 'integer', example: 3, nullable: true),
                    new OA\Property(property: 'from_location', type: 'string', example: 'DELHI'),
                    new OA\Property(property: 'to_location', type: 'string', example: 'MUMBAI'),
                    new OA\Property(property: 'start_date', type: 'string', format: 'date', example: '2026-03-20')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Trip created successfully'),
            new OA\Response(response: 422, description: 'Validation Error')
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:users,id',
            'dealer_id' => 'nullable|exists:dealers,id',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $user = $request->user();
        $ownerId = $user->hasRole('owner') ? $user->id : $user->owner_id;

        // If driver is creating, force driver_id to their own ID
        $data = $request->all();
        if ($user->hasRole('driver')) {
            $data['driver_id'] = $user->id;
        }

        try {
            $trip = $this->tripService->createTrip($data, $ownerId);
            return $this->sendResponse($trip, 'Trip created successfully.', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->sendError('Failed to create trip', ['error' => $e->getMessage()], 400);
        }
    }

    #[OA\Get(
        path: '/api/trips/{id}',
        tags: ['Trips'],
        summary: 'Get specific trip details',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Trip details retrieved successfully'),
            new OA\Response(response: 404, description: 'Trip not found')
        ]
    )]
    public function show(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $driverId = $user->hasRole('driver') ? $user->id : null;

        try {
            $data = $this->tripService->loadTripData((int)$id, $driverId);
            return $this->sendResponse($data, 'Trip details retrieved successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->sendError('Trip not found or unauthorized view.', [], 404);
        }
    }

    #[OA\Put(
        path: '/api/trips/{id}/status',
        tags: ['Trips'],
        summary: 'Update trip status',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['status'],
                properties: [
                    new OA\Property(property: 'status', type: 'string', enum: ['scheduled', 'in_transit', 'completed'])
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Status updated successfully')
        ]
    )]
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:scheduled,in_transit,completed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $user = $request->user();
        $driverId = $user->hasRole('driver') ? $user->id : null;

        try {
            $tripData = $this->tripService->loadTripData((int)$id, $driverId);
            $this->tripService->updateStatus($tripData['tripDetails'], $request->status);
            return $this->sendResponse([], 'Status updated successfully.');
        } catch (\Exception $e) {
             return $this->sendError('Failed to update status', ['error' => $e->getMessage()], 400);
        }
    }

    #[OA\Post(
        path: '/api/trips/{id}/end',
        tags: ['Trips'],
        summary: 'End a trip',
        description: 'Marks trip as completed and releases the vehicle.',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Trip ended successfully')
        ]
    )]
    public function endTrip(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $driverId = $user->hasRole('driver') ? $user->id : null;

        try {
            $tripData = $this->tripService->loadTripData((int)$id, $driverId);
            $this->tripService->endTrip($tripData['tripDetails']);
            return $this->sendResponse([], 'Trip ended successfully.');
        } catch (\Exception $e) {
             return $this->sendError('Failed to end trip', ['error' => $e->getMessage()], 400);
        }
    }
}
