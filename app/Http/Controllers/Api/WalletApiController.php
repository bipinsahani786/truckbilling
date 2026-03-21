<?php

namespace App\Http\Controllers\Api;

use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class WalletApiController extends BaseController
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    #[OA\Get(
        path: '/api/wallets',
        tags: ['Driver Wallets'],
        summary: 'Get driver wallets',
        description: 'Owner gets all driver wallets, driver gets their own wallet.',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Wallets retrieved successfully')
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasRole('owner')) {
            $wallets = Wallet::with('driver')
                ->whereHas('driver', function ($q) use ($user) {
                    $q->where('owner_id', $user->id);
                })
                ->paginate(10);
            return $this->sendResponse($wallets, 'Wallets retrieved successfully.');
        } 
        
        if ($user->hasRole('driver')) {
            $wallet = Wallet::where('driver_id', $user->id)->first();
            return $this->sendResponse($wallet ? [$wallet] : [], 'Wallet retrieved successfully.');
        }

        return $this->sendError('Unauthorized.', [], 403);
    }

    #[OA\Post(
        path: '/api/wallets/add-funds',
        tags: ['Driver Wallets'],
        summary: 'Add funds to a driver wallet',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['driver_id', 'amount'],
                properties: [
                    new OA\Property(property: 'driver_id', type: 'integer', example: 2),
                    new OA\Property(property: 'amount', type: 'number', example: 1000.00),
                    new OA\Property(property: 'remarks', type: 'string', example: 'Advance pay', nullable: true)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Funds added successfully')
        ]
    )]
    public function addFunds(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $validator = Validator::make($request->all(), [
            'driver_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        try {
            $wallet = \App\Models\Wallet::where('driver_id', (int)$request->driver_id)->firstOrFail();
            $this->walletService->addFunds(
                $wallet->id,
                (float)$request->amount,
                $request->remarks ?? 'Funds added via API'
            );
            return $this->sendResponse($wallet->fresh(), 'Funds added successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->sendError('Wallet not found for this driver.', [], 404);
        } catch (\InvalidArgumentException $e) {
             return $this->sendError('Failed to add funds', ['error' => $e->getMessage()], 400);
        }
    }

    #[OA\Get(
        path: '/api/wallets/{id}/transactions',
        tags: ['Driver Wallets'],
        summary: 'Get wallet transaction history',
        description: 'Retrieves a paginated list of transactions for a specific wallet.',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Transactions retrieved successfully'),
            new OA\Response(response: 403, description: 'Unauthorized'),
            new OA\Response(response: 404, description: 'Wallet not found')
        ]
    )]
    public function transactions(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $wallet = \App\Models\Wallet::findOrFail($id);

        // Security check: Owner can see their driver's wallets, Driver can only see their own
        if ($user->hasRole('owner')) {
            $driver = \App\Models\User::find($wallet->driver_id);
            if (!$driver || $driver->owner_id !== $user->id) {
                return $this->sendError('Unauthorized access to this wallet.', [], 403);
            }
        } elseif ($user->hasRole('driver')) {
            if ($wallet->driver_id !== $user->id) {
                return $this->sendError('Unauthorized access to this wallet.', [], 403);
            }
        } else {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $transactions = \App\Models\WalletTransaction::where('wallet_id', $wallet->id)
            ->latest()
            ->paginate(15);

        return $this->sendResponse($transactions, 'Transactions retrieved successfully.');
    }
}
