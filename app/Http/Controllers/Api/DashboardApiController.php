<?php

namespace App\Http\Controllers\Api;

use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardApiController extends BaseController
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * @OA\Get(
     *     path="/api/dashboard",
     *     tags={"Dashboard"},
     *     summary="Get dashboard statistics",
     *     description="Retrieve key metrics and recent trips based on the authenticated user's role.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Dashboard data retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Dashboard data retrieved."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="stats", type="object",
     *                     @OA\Property(property="active_trips", type="integer", example=5),
     *                     @OA\Property(property="available_trucks", type="integer", example=10),
     *                     @OA\Property(property="monthly_revenue", type="number", example=150000),
     *                     @OA\Property(property="monthly_expense", type="number", example=45000)
     *                 ),
     *                 @OA\Property(property="recent_trips", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="cashflow_chart", type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Use the same dashboard service logic used by the web interface
        $data = $this->dashboardService->getDashboardData($user);
        
        // We only append chart data if the user is an owner, drivers don't see it (for example)
        if ($user->hasRole('owner')) {
            $data['cashflow_chart'] = $this->dashboardService->getChartData($user);
        }

        return $this->sendResponse($data, 'Dashboard data retrieved successfully.');
    }
}
