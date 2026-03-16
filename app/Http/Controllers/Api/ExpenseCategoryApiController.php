<?php

namespace App\Http\Controllers\Api;

use App\Models\ExpenseCategory;
use App\Services\ExpenseCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class ExpenseCategoryApiController extends BaseController
{
    protected ExpenseCategoryService $categoryService;

    public function __construct(ExpenseCategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    #[OA\Get(
        path: '/api/expense-categories',
        tags: ['Expense Categories'],
        summary: 'Get all expense categories',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Categories retrieved successfully')
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner') && !$user->hasRole('super-admin')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        // Super-admin only sees global categories (we can abstract this logic, but for now we follow the web controller pattern)
        $ownerId = $user->hasRole('owner') ? $user->id : null; 
        
        $categories = $this->categoryService->getFilteredCategories(
            $user->id,
            $user->hasRole('super-admin'),
            $request->query('search')
        );

        return $this->sendResponse($categories, 'Categories retrieved successfully.');
    }

    #[OA\Post(
        path: '/api/expense-categories',
        tags: ['Expense Categories'],
        summary: 'Create a new expense category',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Fuel')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Category created successfully'),
            new OA\Response(response: 422, description: 'Validation Error')
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner') && !$user->hasRole('super-admin')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $ownerId = $user->hasRole('owner') ? $user->id : null;

        try {
            $cat = $this->categoryService->createOrUpdate(
                ['name' => $request->name],
                $user->id,
                $user->hasRole('super-admin')
            );
            return $this->sendResponse($cat, 'Category created successfully.', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->sendError('Failed to create category', ['error' => $e->getMessage()], 400);
        }
    }

    #[OA\Delete(
        path: '/api/expense-categories/{id}',
        tags: ['Expense Categories'],
        summary: 'Delete an expense category',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Category deleted successfully')
        ]
    )]
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('owner') && !$user->hasRole('super-admin')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $ownerId = $user->hasRole('owner') ? $user->id : null;

        try {
            $this->categoryService->delete($id, $user->id, $user->hasRole('super-admin'));
            return $this->sendResponse([], 'Category deleted successfully.');
        } catch (\InvalidArgumentException $e) {
            return $this->sendError('Failed to delete', ['error' => $e->getMessage()], 400);
        }
    }
}
