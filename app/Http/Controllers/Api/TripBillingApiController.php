<?php

namespace App\Http\Controllers\Api;

use App\Models\Trip;
use App\Models\TripBilling;
use App\Services\TripBillingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class TripBillingApiController extends BaseController
{
    protected TripBillingService $billingService;

    public function __construct(TripBillingService $billingService)
    {
        $this->billingService = $billingService;
    }

    #[OA\Post(
        path: '/api/trips/{trip_id}/billings',
        tags: ['Trip Billings'],
        summary: 'Add a billing entry to a trip',
        description: 'Creates a new party billing entry for a specific trip.',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'trip_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['freight_amount'],
                properties: [
                    new OA\Property(property: 'party_name', type: 'string', example: 'ABC Corp'),
                    new OA\Property(property: 'material_description', type: 'string', example: 'Cement'),
                    new OA\Property(property: 'weight_tons', type: 'number', example: 15.5),
                    new OA\Property(property: 'freight_amount', type: 'number', example: 25000.00),
                    new OA\Property(property: 'received_amount', type: 'number', example: 5000.00)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Billing added successfully'),
            new OA\Response(response: 422, description: 'Validation Error')
        ]
    )]
    public function store(Request $request, $tripId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'freight_amount' => 'required|numeric|min:0',
            'party_name' => 'nullable|string|max:255',
            'material_description' => 'nullable|string',
            'weight_tons' => 'nullable|numeric',
            'received_amount' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $trip = Trip::findOrFail($tripId);
        $user = $request->user();

        if ($user->hasRole('driver') && $trip->driver_id !== $user->id) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $bill = $this->billingService->createOrUpdate($trip->id, $request->all());
        return $this->sendResponse($bill, 'Billing added successfully.', 201);
    }

    #[OA\Put(
        path: '/api/billings/{id}',
        tags: ['Trip Billings'],
        summary: 'Update a billing entry',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['freight_amount'],
                properties: [
                    new OA\Property(property: 'party_name', type: 'string', example: 'ABC Corp'),
                    new OA\Property(property: 'material_description', type: 'string', example: 'Cement'),
                    new OA\Property(property: 'weight_tons', type: 'number', example: 15.5),
                    new OA\Property(property: 'freight_amount', type: 'number', example: 26000.00),
                    new OA\Property(property: 'received_amount', type: 'number', example: 6000.00)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Billing updated successfully')
        ]
    )]
    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'freight_amount' => 'required|numeric|min:0',
            'party_name' => 'nullable|string|max:255',
            'material_description' => 'nullable|string',
            'weight_tons' => 'nullable|numeric',
            'received_amount' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $bill = TripBilling::with('trip')->findOrFail($id);
        $user = $request->user();

        if ($user->hasRole('driver') && $bill->trip->driver_id !== $user->id) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $bill = $this->billingService->createOrUpdate($bill->trip_id, $request->all(), $bill->id);
        return $this->sendResponse($bill, 'Billing updated successfully.');
    }

    #[OA\Delete(
        path: '/api/billings/{id}',
        tags: ['Trip Billings'],
        summary: 'Delete a billing entry',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Billing deleted successfully')
        ]
    )]
    public function destroy(Request $request, $id): JsonResponse
    {
        $bill = TripBilling::with('trip')->findOrFail($id);
        $user = $request->user();

        if ($user->hasRole('driver') && $bill->trip->driver_id !== $user->id) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $this->billingService->delete($bill->id);
        return $this->sendResponse([], 'Billing deleted successfully.');
    }
}
