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
                        new OA\Property(property: 'insurance_expiry_date', type: 'string', format: 'date', example: '2026-03-20', nullable: true),
                        new OA\Property(property: 'fitness_expiry_date', type: 'string', format: 'date', example: '2026-03-20', nullable: true),
                        new OA\Property(property: 'national_permit_expiry_date', type: 'string', format: 'date', example: '2026-03-20', nullable: true),
                        new OA\Property(property: 'pollution_expiry_date', type: 'string', format: 'date', example: '2026-03-20', nullable: true),
                        new OA\Property(property: 'rc_document', type: 'string', format: 'binary'),
                        new OA\Property(property: 'insurance_document', type: 'string', format: 'binary'),
                        new OA\Property(property: 'fitness_document', type: 'string', format: 'binary'),
                        new OA\Property(property: 'truck_photo', type: 'string', format: 'binary')
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
            'insurance_expiry_date' => 'nullable|date',
            'fitness_expiry_date' => 'nullable|date',
            'national_permit_expiry_date' => 'nullable|date',
            'pollution_expiry_date' => 'nullable|date',
            'rc_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'insurance_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'fitness_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'truck_photo' => 'nullable|file|mimes:jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $files = $request->only(['rc_document', 'insurance_document', 'fitness_document', 'truck_photo']);

        $vehicle = $this->vehicleService->createOrUpdate(
            $request->all(),
            $files,
            $user->id
        );

        return $this->sendResponse($vehicle, 'Vehicle created successfully.', 201);
    }

    #[OA\Post(
        path: '/api/vehicles/{id}',
        tags: ['Vehicles'],
        summary: 'Update an existing vehicle',
        description: 'Update vehicle details and documents. Use standard POST for multipart/form-data support.',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'truck_number', type: 'string', example: 'MH-12-AB-1234'),
                        new OA\Property(property: 'truck_type', type: 'string', example: 'Open Body'),
                        new OA\Property(property: 'capacity_tons', type: 'number', example: 10.5, nullable: true),
                        new OA\Property(property: 'rc_number', type: 'string', example: 'RC123456', nullable: true),
                        new OA\Property(property: 'chassis_number', type: 'string', example: 'CH123456789'),
                        new OA\Property(property: 'engine_number', type: 'string', example: 'EN123456789'),
                        new OA\Property(property: 'insurance_expiry_date', type: 'string', format: 'date', example: '2026-03-20', nullable: true),
                        new OA\Property(property: 'fitness_expiry_date', type: 'string', format: 'date', example: '2026-03-20', nullable: true),
                        new OA\Property(property: 'national_permit_expiry_date', type: 'string', format: 'date', example: '2026-03-20', nullable: true),
                        new OA\Property(property: 'pollution_expiry_date', type: 'string', format: 'date', example: '2026-03-20', nullable: true),
                        new OA\Property(property: 'rc_document', type: 'string', format: 'binary'),
                        new OA\Property(property: 'insurance_document', type: 'string', format: 'binary'),
                        new OA\Property(property: 'fitness_document', type: 'string', format: 'binary'),
                        new OA\Property(property: 'truck_photo', type: 'string', format: 'binary'),
                        new OA\Property(property: 'status', type: 'string', enum: ['active', 'maintenance', 'inactive'])
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Vehicle updated successfully'),
            new OA\Response(response: 422, description: 'Validation Error'),
            new OA\Response(response: 404, description: 'Vehicle not found')
        ]
    )]
    public function update(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $vehicle = Vehicle::where('owner_id', $user->id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'truck_number' => 'sometimes|required|string|unique:vehicles,truck_number,' . $id,
            'truck_type' => 'sometimes|required|string',
            'capacity_tons' => 'sometimes|nullable|numeric',
            'rc_number' => 'sometimes|nullable|string',
            'chassis_number' => 'sometimes|required|string|unique:vehicles,chassis_number,' . $id,
            'engine_number' => 'sometimes|required|string|unique:vehicles,engine_number,' . $id,
            'insurance_expiry_date' => 'sometimes|nullable|date',
            'fitness_expiry_date' => 'sometimes|nullable|date',
            'national_permit_expiry_date' => 'sometimes|nullable|date',
            'pollution_expiry_date' => 'sometimes|nullable|date',
            'rc_document' => 'sometimes|nullable|file|mimes:pdf,jpg,png|max:2048',
            'insurance_document' => 'sometimes|nullable|file|mimes:pdf,jpg,png|max:2048',
            'fitness_document' => 'sometimes|nullable|file|mimes:pdf,jpg,png|max:2048',
            'truck_photo' => 'sometimes|nullable|file|mimes:jpg,png|max:2048',
            'status' => 'sometimes|required|in:active,maintenance,inactive',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $files = $request->only(['rc_document', 'insurance_document', 'fitness_document', 'truck_photo']);

        $vehicle = $this->vehicleService->createOrUpdate(
            $request->all(),
            $files,
            $user->id,
            (int)$id
        );

        return $this->sendResponse($vehicle, 'Vehicle updated successfully.');
    }

    #[OA\Delete(
        path: '/api/vehicles/{id}',
        tags: ['Vehicles'],
        summary: 'Delete a vehicle',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Vehicle deleted successfully'),
            new OA\Response(response: 404, description: 'Vehicle not found')
        ]
    )]
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $vehicle = Vehicle::where('owner_id', $user->id)->findOrFail($id);
        
        // Service should handle document deletion if necessary, but here we just delete the model
        // which triggers cascade or we can manually delete files.
        // Let's assume the service handles cleanup or we do it here.
        // For simplicity, we delete the vehicle.
        $vehicle->delete();

        return $this->sendResponse([], 'Vehicle deleted successfully.');
    }
}
