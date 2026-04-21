<?php

namespace App\Http\Controllers\Api;

use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class DashboardApiController extends BaseController
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    #[OA\Get(
        path: '/api/dashboard',
        tags: ['Dashboard'],
        summary: 'Get dashboard statistics',
        description: "Retrieve key metrics and recent trips based on the authenticated user's role.",
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'from_date', in: 'query', description: 'Start date (YYYY-MM-DD)', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'to_date', in: 'query', description: 'End date (YYYY-MM-DD)', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'status', in: 'query', description: 'Trip status filter', required: false, schema: new OA\Schema(type: 'string'))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Dashboard data retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Dashboard data retrieved successfully.'),
                        new OA\Property(property: 'data', type: 'object',
                            properties: [
                                new OA\Property(property: 'totalRevenue', type: 'number', example: 150000),
                                new OA\Property(property: 'totalExpenses', type: 'number', example: 45000),
                                new OA\Property(property: 'netProfit', type: 'number', example: 105000),
                                new OA\Property(property: 'pendingDues', type: 'number', example: 25000),
                                new OA\Property(property: 'totalVehicles', type: 'integer', example: 10),
                                new OA\Property(property: 'onRoadVehicles', type: 'integer', example: 5),
                                new OA\Property(property: 'fleetPercentage', type: 'integer', example: 50),
                                new OA\Property(property: 'liveTrips', type: 'array', items: new OA\Items(type: 'object')),
                                new OA\Property(property: 'cashflow_chart', type: 'object', nullable: true)
                            ]
                        )
                    ]
                )
            )
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        
        $isDriver = $user->hasRole('driver');
        $ownerId = $isDriver ? $user->owner_id : $user->id;
        $driverId = $isDriver ? $user->id : null;

        // Support optional filters
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');
        $status = $request->query('status');

        // Get main dashboard metrics
        $data = $this->dashboardService->getDashboardData(
            (int)$ownerId,
            (bool)$isDriver,
            $driverId,
            $fromDate,
            $toDate,
            $status
        );
        
        // Append chart data (Owners see full chart, Drivers see their own)
        $data['cashflow_chart'] = $this->dashboardService->getChartData(
            (int)$ownerId,
            (bool)$isDriver,
            $driverId,
            $toDate
        );

        return $this->sendResponse($data, 'Dashboard data retrieved successfully.');
    }
}
