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
                required: ['company_name', 'contact_person_name', 'mobile_number'],
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
            'gstin' => 'nullable|string|max:15|unique:dealers',
            'pan_number' => 'nullable|string|max:10|unique:dealers',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        // dd($request->all());
        try {
            $dealer = $this->dealerService->createOrUpdate($request->all(), $user->id);
            return $this->sendResponse($dealer, 'Dealer created successfully.', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->sendError('Failed to create dealer', ['error' => $e->getMessage()], 400);
        }
    }
}
