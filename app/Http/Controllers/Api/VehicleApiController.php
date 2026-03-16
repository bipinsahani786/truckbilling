<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class VehicleApiController extends BaseController
{
    protected VehicleService $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    #[OA\Get(
        path: '/api/vehicles',
        tags: ['Vehicles'],
        summary: 'Get all vehicles',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'status', in: 'query', required: false, schema: new OA\Schema(type: 'string'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Vehicles retrieved successfully')
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $vehicles = $this->vehicleService->getFilteredVehicles(
            $user->id,
            $request->query('search'),
            $request->query('status')
        );

        return $this->sendResponse($vehicles, 'Vehicles retrieved successfully.');
    }

    #[OA\Get(
        path: '/api/vehicles/stats',
        tags: ['Vehicles'],
        summary: 'Get vehicle statistics',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Stats retrieved successfully')
        ]
    )]
    public function stats(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $stats = $this->vehicleService->getStats($user->id);
        return $this->sendResponse($stats, 'Vehicle stats retrieved successfully.');
    }

    #[OA\Get(
        path: '/api/vehicles/{id}',
        tags: ['Vehicles'],
        summary: 'Get specific vehicle',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Vehicle retrieved successfully')
        ]
    )]
    public function show(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $vehicle = Vehicle::where('owner_id', $user->id)->findOrFail($id);
        return $this->sendResponse($vehicle, 'Vehicle retrieved successfully.');
    }

    #[OA\Post(
        path: '/api/vehicles',
        tags: ['Vehicles'],
        summary: 'Create a new vehicle',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['truck_number', 'truck_type', 'chassis_number', 'engine_number'],
                    properties: [
                        new OA\Property(property: 'truck_number', type: 'string', example: 'MH-12-AB-1234'),
                        new OA\Property(property: 'truck_type', type: 'string', example: 'Open Body'),
                        new OA\Property(property: 'capacity_tons', type: 'number', example: 10.5, nullable: true),
                        new OA\Property(property: 'rc_number', type: 'string', example: 'RC123456', nullable: true),
                        new OA\Property(property: 'chassis_number', type: 'string', example: 'CH123456789'),
                        new OA\Property(property: 'engine_number', type: 'string', example: 'EN123456789'),
                        new OA\Property(property: 'rc_document', type: 'string', format: 'binary')
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Vehicle created successfully'),
            new OA\Response(response: 422, description: 'Validation Error')
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $validator = Validator::make($request->all(), [
            'truck_number' => 'required|string|unique:vehicles',
            'truck_type' => 'required|string',
            'capacity_tons' => 'nullable|numeric',
            'rc_number' => 'nullable|string',
            'chassis_number' => 'required|string|unique:vehicles',
            'engine_number' => 'required|string|unique:vehicles',
            'rc_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $files = $request->hasFile('rc_document') ? ['rc_document' => $request->file('rc_document')] : null;

        $vehicle = $this->vehicleService->createOrUpdate(
            $request->all(),
            $files,
            $user->id
        );

        return $this->sendResponse($vehicle, 'Vehicle created successfully.', 201);
    }
}
