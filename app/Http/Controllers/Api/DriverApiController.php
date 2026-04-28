<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\DriverService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;

class DriverApiController extends BaseController
{
    protected DriverService $driverService;

    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    #[OA\Get(
        path: '/api/drivers',
        tags: ['Drivers'],
        summary: 'Get all drivers',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Drivers retrieved successfully')
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $drivers = User::role('driver')
            ->where('owner_id', $user->id)
            ->when($request->query('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('mobile', 'like', "%{$search}%");
                });
            })->paginate(10);

        return $this->sendResponse($drivers, 'Drivers retrieved successfully.');
    }

    #[OA\Post(
        path: '/api/drivers',
        tags: ['Drivers'],
        summary: 'Create a new driver',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['name', 'mobile_number', 'password'],
                    properties: [
                        new OA\Property(property: 'name', type: 'string', example: 'Driver John'),
                        new OA\Property(property: 'mobile_number', type: 'string', example: '9876543210'),
                        new OA\Property(property: 'email', type: 'string', example: 'driver@jmdtrucks.com', nullable: true),
                        new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123'),
                        new OA\Property(property: 'license_number', type: 'string', example: 'DL-123456789', nullable: true),
                        new OA\Property(property: 'aadhar_number', type: 'string', example: '123456789012', nullable: true),
                        new OA\Property(property: 'address', type: 'string', example: 'Delhi', nullable: true),
                        new OA\Property(property: 'blood_group', type: 'string', example: 'O+', nullable: true),
                        new OA\Property(property: 'license_document', type: 'string', format: 'binary'),
                        new OA\Property(property: 'aadhar_document', type: 'string', format: 'binary')
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Driver created successfully'),
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
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|unique:users,mobile_number',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'license_number' => 'nullable|string|max:50',
            'aadhar_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'blood_group' => 'nullable|string|max:5',
            'license_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'aadhar_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $driver = $this->driverService->createDriver(
            $request->all(),
            $user->id,
            $request->file('license_document'),
            $request->file('aadhar_document')
        );

        return $this->sendResponse($driver, 'Driver created successfully.', 201);
    }

    #[OA\Get(
        path: '/api/drivers/{id}',
        tags: ['Drivers'],
        summary: 'Get specific driver details',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Driver retrieved successfully'),
            new OA\Response(response: 404, description: 'Driver not found')
        ]
    )]
    public function show(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $driver = User::role('driver')->where('owner_id', $user->id)->findOrFail($id);
        return $this->sendResponse($driver, 'Driver retrieved successfully.');
    }

    #[OA\Post(
        path: '/api/drivers/{id}',
        tags: ['Drivers'],
        summary: 'Update a driver',
        description: 'Update driver details and documents. Use POST with _method=PUT for multipart/form-data support.',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['name', 'mobile_number'],
                    properties: [
                        new OA\Property(property: '_method', type: 'string', example: 'PUT'),
                        new OA\Property(property: 'name', type: 'string', example: 'Driver John Updated'),
                        new OA\Property(property: 'mobile_number', type: 'string', example: '9876543210'),
                        new OA\Property(property: 'email', type: 'string', example: 'driver@jmdtrucks.com', nullable: true),
                        new OA\Property(property: 'password', type: 'string', format: 'password', example: 'newpassword123', nullable: true),
                        new OA\Property(property: 'license_number', type: 'string', example: 'DL-123456789', nullable: true),
                        new OA\Property(property: 'aadhar_number', type: 'string', example: '123456789012', nullable: true),
                        new OA\Property(property: 'address', type: 'string', example: 'Delhi NCR', nullable: true),
                        new OA\Property(property: 'blood_group', type: 'string', example: 'A+', nullable: true),
                        new OA\Property(property: 'license_document', type: 'string', format: 'binary'),
                        new OA\Property(property: 'aadhar_document', type: 'string', format: 'binary')
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Driver updated successfully'),
            new OA\Response(response: 422, description: 'Validation Error'),
            new OA\Response(response: 404, description: 'Driver not found')
        ]
    )]
    public function update(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $driver = User::role('driver')->where('owner_id', $user->id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|unique:users,mobile_number,' . $id,
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'license_number' => 'nullable|string|max:50',
            'aadhar_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'blood_group' => 'nullable|string|max:5',
            'license_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'aadhar_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $driver = $this->driverService->updateDriver(
            (int)$id,
            $request->all(),
            $request->file('license_document'),
            $request->file('aadhar_document')
        );

        return $this->sendResponse($driver, 'Driver updated successfully.');
    }

    #[OA\Delete(
        path: '/api/drivers/{id}',
        tags: ['Drivers'],
        summary: 'Delete a driver',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Driver deleted successfully'),
            new OA\Response(response: 404, description: 'Driver not found')
        ]
    )]
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $driver = User::role('driver')->where('owner_id', $user->id)->findOrFail($id);
        
        // Manual cleanup of files if not handled by observers
        if ($driver->license_document_path) {
            Storage::disk('public')->delete($driver->license_document_path);
        }
        if ($driver->aadhar_document_path) {
            Storage::disk('public')->delete($driver->aadhar_document_path);
        }

        $driver->delete();

        return $this->sendResponse([], 'Driver deleted successfully.');
    }
}
