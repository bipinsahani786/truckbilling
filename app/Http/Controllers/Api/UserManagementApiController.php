<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\UserManagementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class UserManagementApiController extends BaseController
{
    protected UserManagementService $userService;

    public function __construct(UserManagementService $userService)
    {
        $this->userService = $userService;
    }

    #[OA\Get(
        path: '/api/users',
        tags: ['Super Admin Users'],
        summary: 'Get all users',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'role', in: 'query', required: false, schema: new OA\Schema(type: 'string'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Users retrieved successfully')
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('super-admin')) {
            return $this->sendError('Unauthorized. Super-admin only.', [], 403);
        }

        $users = $this->userService->getFilteredUsers(
            $request->query('search'),
            $request->query('role')
        );

        return $this->sendResponse($users, 'Users retrieved successfully.');
    }

    #[OA\Post(
        path: '/api/users/{id}/toggle-block',
        tags: ['Super Admin Users'],
        summary: 'Block or unblock a user',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'User blocked/unblocked successfully')
        ]
    )]
    public function toggleBlock(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('super-admin')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        try {
            $blockedUser = $this->userService->toggleBlock((int)$id);
            $msg = $blockedUser->is_blocked ? 'User has been blocked.' : 'User has been unblocked.';
            return $this->sendResponse(['is_blocked' => $blockedUser->is_blocked], $msg);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return $this->sendError('User not found.', [], 404);
        }
    }

    #[OA\Post(
        path: '/api/users/{id}/reset-password',
        tags: ['Super Admin Users'],
        summary: 'Reset a user password manually',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['password', 'password_confirmation'],
                properties: [
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'newpassword123'),
                    new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'newpassword123')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Password reset successfully')
        ]
    )]
    public function resetPassword(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->hasRole('super-admin')) {
            return $this->sendError('Unauthorized.', [], 403);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        try {
            $this->userService->resetPasswordManual((int)$id, $request->password);
            return $this->sendResponse([], 'Password reset successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return $this->sendError('User not found.', [], 404);
        }
    }
}
