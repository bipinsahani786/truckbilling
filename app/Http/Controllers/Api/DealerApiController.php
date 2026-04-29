<?php

namespace App\Http\Controllers\Api;

use App\Models\Dealer;
use App\Services\DealerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class DealerApiController extends BaseController
{
    protected DealerService $dealerService;

    public function __construct(DealerService $dealerService)
    {
        $this->dealerService = $dealerService;
    }

    #[OA\Get(
        path: '/api/dealers',
        tags: ['Dealers'],
        summary: 'Get all dealers',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Dealers retrieved successfully')
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $dealers = $this->dealerService->getFilteredDealers(
            $user->id,
            $request->query('search')
        );

        return $this->sendResponse($dealers, 'Dealers retrieved successfully.');
    }

    #[OA\Post(
        path: '/api/dealers',
        tags: ['Dealers'],
        summary: 'Create a new dealer',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['company_name', 'contact_person_name', 'phone_number'],
                properties: [
                    new OA\Property(property: 'company_name', type: 'string', example: 'ABC Logistics'),
                    new OA\Property(property: 'contact_person_name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'phone_number', type: 'string', example: '9876543210'),
                    new OA\Property(property: 'email', type: 'string', example: 'john@abc.com', nullable: true),
                    new OA\Property(property: 'gstin', type: 'string', example: '22AAAAA0000A1Z5', nullable: true),
                    new OA\Property(property: 'pan_number', type: 'string', example: 'ABCDE1234F', nullable: true),
                    new OA\Property(property: 'address', type: 'string', example: 'Mumbai', nullable: true)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Dealer created successfully'),
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
            'company_name' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'gstin' => 'nullable|string|unique:dealers',
            'pan_number' => 'nullable|string|unique:dealers',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        try {
            $dealer = $this->dealerService->createOrUpdate($request->all(), $user->id);
            return $this->sendResponse($dealer, 'Dealer created successfully.', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->sendError('Failed to create dealer', ['error' => $e->getMessage()], 400);
        }
    }

    #[OA\Get(
        path: '/api/dealers/{id}',
        tags: ['Dealers'],
        summary: 'Get specific dealer details',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Dealer retrieved successfully'),
            new OA\Response(response: 404, description: 'Dealer not found')
        ]
    )]
    public function show(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $dealer = Dealer::where('owner_id', $user->id)->findOrFail($id);
        return $this->sendResponse($dealer, 'Dealer retrieved successfully.');
    }

    #[OA\Put(
        path: '/api/dealers/{id}',
        tags: ['Dealers'],
        summary: 'Update a dealer',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['company_name', 'contact_person_name', 'phone_number'],
                properties: [
                    new OA\Property(property: 'company_name', type: 'string', example: 'ABC Logistics Updated'),
                    new OA\Property(property: 'contact_person_name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'phone_number', type: 'string', example: '9876543210'),
                    new OA\Property(property: 'email', type: 'string', example: 'john@abc.com', nullable: true),
                    new OA\Property(property: 'gstin', type: 'string', example: '22AAAAA0000A1Z5', nullable: true),
                    new OA\Property(property: 'pan_number', type: 'string', example: 'ABCDE1234F', nullable: true),
                    new OA\Property(property: 'address', type: 'string', example: 'Navi Mumbai', nullable: true)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Dealer updated successfully'),
            new OA\Response(response: 422, description: 'Validation Error'),
            new OA\Response(response: 404, description: 'Dealer not found')
        ]
    )]
    public function update(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $dealer = Dealer::where('owner_id', $user->id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'gstin' => 'nullable|string|unique:dealers,gstin,' . $id,
            'pan_number' => 'nullable|string|unique:dealers,pan_number,' . $id,
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        try {
            $dealer = $this->dealerService->createOrUpdate($request->all(), $user->id, (int)$id);
            return $this->sendResponse($dealer, 'Dealer updated successfully.');
        } catch (\InvalidArgumentException $e) {
            return $this->sendError('Failed to update dealer', ['error' => $e->getMessage()], 400);
        }
    }

    #[OA\Delete(
        path: '/api/dealers/{id}',
        tags: ['Dealers'],
        summary: 'Delete a dealer',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Dealer deleted successfully'),
            new OA\Response(response: 404, description: 'Dealer not found')
        ]
    )]
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $dealer = Dealer::where('owner_id', $user->id)->findOrFail($id);
        $dealer->delete();

        return $this->sendResponse([], 'Dealer deleted successfully.');
    }
}
