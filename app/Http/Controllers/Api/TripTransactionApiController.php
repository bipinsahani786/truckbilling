<?php

namespace App\Http\Controllers\Api;

use App\Models\Trip;
use App\Models\TripTransaction;
use App\Services\TripTransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class TripTransactionApiController extends BaseController
{
    protected TripTransactionService $txService;

    public function __construct(TripTransactionService $txService)
    {
        $this->txService = $txService;
    }

    #[OA\Post(
        path: '/api/trips/{trip_id}/transactions',
        tags: ['Trip Transactions'],
        summary: 'Add a transaction to a trip',
        description: 'Creates an expense or recovery transaction for a specific trip, adjusting wallets automatically.',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'trip_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['transaction_type', 'expense_category_id', 'amount', 'payment_mode'],
                properties: [
                    new OA\Property(property: 'transaction_type', type: 'string', enum: ['expense', 'recovery']),
                    new OA\Property(property: 'expense_category_id', type: 'integer', example: 1),
                    new OA\Property(property: 'amount', type: 'number', example: 500.00),
                    new OA\Property(property: 'payment_mode', type: 'string', enum: ['wallet', 'owner_bank', 'fastag']),
                    new OA\Property(property: 'remarks', type: 'string', example: 'Toll tax')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Transaction added successfully'),
            new OA\Response(response: 422, description: 'Validation Error')
        ]
    )]
    
    public function store(Request $request, $tripId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'transaction_type' => 'required|in:expense,recovery',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:1',
            'payment_mode' => 'required|in:wallet,owner_bank,fastag',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $trip = Trip::findOrFail($tripId);
        $user = $request->user();

        // Security: drivers can only add transactions to their own trips
        if ($user->hasRole('driver') && $trip->driver_id !== $user->id) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $data = $request->all();
        $data['trip_id'] = $trip->id;
        $data['added_by'] = $user->id;

        try {
            $tx = $this->txService->createOrUpdate($data, null, $trip->driver_id, $trip->id);
            return $this->sendResponse($tx, 'Transaction added successfully.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to add transaction', ['error' => $e->getMessage()], 400); // 400 for bad request
        }
    }

    #[OA\Delete(
        path: '/api/transactions/{id}',
        tags: ['Trip Transactions'],
        summary: 'Delete a transaction',
        description: 'Deletes a transaction and reverses its effect on the driver wallet.',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Transaction deleted successfully')
        ]
    )]
    public function destroy(Request $request, $id): JsonResponse
    {
        $tx = TripTransaction::with('trip')->findOrFail($id);
        $user = $request->user();

        // Only owner or the driver assigned to this trip can delete it
        if ($user->hasRole('driver') && $tx->trip->driver_id !== $user->id) {
             return $this->sendError('Unauthorized.', [], 403);
        }

        try {
            $this->txService->delete($tx->id, $tx->trip->driver_id, $tx->trip_id);
            return $this->sendResponse([], 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete transaction', ['error' => $e->getMessage()], 400);
        }
    }
}
