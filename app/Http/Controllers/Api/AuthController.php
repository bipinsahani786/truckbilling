<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class AuthController extends BaseController
{
    #[OA\Post(
        path: '/api/login',
        tags: ['Authentication'],
        summary: 'Login to the appliction',
        description: 'Authenticate a user and return a token with profile data.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'admin@zytrixon.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful login',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'User logged in successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'token', type: 'string', example: '1|xxx'),
                                new OA\Property(property: 'user_id', type: 'integer', example: 1),
                                new OA\Property(property: 'name', type: 'string', example: 'Admin'),
                                new OA\Property(property: 'roles', type: 'array', items: new OA\Items(type: 'string'))
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthorized')
        ]
    )]
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Check if user is blocked
            if ($user->is_blocked) {
                // Return generic 401 error or a specific message
                return $this->sendError('Your account has been blocked.', ['error' => 'Blocked Account'], 403);
            }

            // Revoke active tokens if needed, but let's allow multiple devices or simple token generation
            $token = $user->createToken('MobileAppToken')->plainTextToken;

            $success['token'] = $token;
            $success['user_id'] = $user->id;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['roles'] = $user->getRoleNames();

            return $this->sendResponse($success, 'User logged in successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Invalid email or password'], 401);
        }
    }

    #[OA\Get(
        path: '/api/user',
        tags: ['Authentication'],
        summary: 'Get authenticated user profile',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Profile retrieved successfully'),
            new OA\Response(response: 401, description: 'Unauthorized')
        ]
    )]
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load('roles'); // Eager load roles
        return $this->sendResponse($user, 'User profile retrieved successfully.');
    }

    #[OA\Post(
        path: '/api/logout',
        tags: ['Authentication'],
        summary: 'Logout the user',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Successfully logged out')
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse([], 'User logged out successfully.');
    }
}
