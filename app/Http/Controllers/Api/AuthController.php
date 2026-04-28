<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;

class AuthController extends BaseController
{
    #[OA\Post(
        path: '/api/forgot-password',
        tags: ['Authentication'],
        summary: 'Request a password reset link',
        description: 'Sends a password reset link to the user\'s email.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'owner@example.com')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Reset link sent successfully'),
            new OA\Response(response: 422, description: 'Validation Error')
        ]
    )]
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? $this->sendResponse([], __($status))
            : $this->sendError('Failed to send reset link.', ['error' => __($status)], 400);
    }

    #[OA\Post(
        path: '/api/reset-password',
        tags: ['Authentication'],
        summary: 'Reset password using token',
        description: 'Update the user\'s password using a valid reset token.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password', 'password_confirmation', 'token'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'owner@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'newpassword123'),
                    new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'newpassword123'),
                    new OA\Property(property: 'token', type: 'string', example: 'token-string')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Password reset successfully'),
            new OA\Response(response: 422, description: 'Validation Error')
        ]
    )]
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? $this->sendResponse([], __($status))
            : $this->sendError('Failed to reset password.', ['error' => __($status)], 400);
    }

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
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'admin@jmdtrucks.com'),
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

    #[OA\Post(
        path: '/api/register',
        tags: ['Authentication'],
        summary: 'Register a new user (Fleet Owner)',
        description: 'Create a new account and return an authentication token.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'password', 'mobile_number'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'secret123'),
                    new OA\Property(property: 'mobile_number', type: 'string', example: '9876543210'),
                    new OA\Property(property: 'company_name', type: 'string', example: 'Doe Logistics')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful registration',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'User registered successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'token', type: 'string', example: '1|xxx'),
                                new OA\Property(property: 'user_id', type: 'integer', example: 2),
                                new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                                new OA\Property(property: 'roles', type: 'array', items: new OA\Items(type: 'string'))
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation Error')
        ]
    )]
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'mobile_number' => 'required|string|max:15|unique:users',
            'company_name' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'mobile_number' => $request->mobile_number,
            'company_name' => $request->company_name,
        ]);

        $user->assignRole('owner');

        $token = $user->createToken('MobileAppToken')->plainTextToken;

        $success['token'] = $token;
        $success['user_id'] = $user->id;
        $success['name'] = $user->name;
        $success['email'] = $user->email;
        $success['roles'] = $user->getRoleNames();

        return $this->sendResponse($success, 'User registered successfully.');
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

    #[OA\Post(
        path: '/api/user/profile',
        tags: ['User Profile'],
        summary: 'Update authenticated user profile',
        description: 'Update profile details including profile photo. Use POST with _method=PUT for multipart support.',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['name', 'email'],
                    properties: [
                        new OA\Property(property: '_method', type: 'string', example: 'PUT'),
                        new OA\Property(property: 'name', type: 'string', example: 'John Updated'),
                        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john@example.com'),
                        new OA\Property(property: 'mobile_number', type: 'string', example: '9876543210'),
                        new OA\Property(property: 'address', type: 'string', example: 'New Street, City'),
                        new OA\Property(property: 'company_name', type: 'string', example: 'My Trucking Co'),
                        new OA\Property(property: 'profile_photo', type: 'string', format: 'binary')
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Profile updated successfully'),
            new OA\Response(response: 422, description: 'Validation Error')
        ]
    )]
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'mobile_number' => 'nullable|string|max:15|unique:users,mobile_number,' . $user->id,
            'address' => 'nullable|string|max:500',
            'company_name' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        $data = $request->only(['name', 'email', 'mobile_number', 'address', 'company_name']);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $data['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->update($data);

        return $this->sendResponse($user, 'Profile updated successfully.');
    }

    #[OA\Post(
        path: '/api/user/change-password',
        tags: ['User Profile'],
        summary: 'Change authenticated user password',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['current_password', 'new_password', 'new_password_confirmation'],
                properties: [
                    new OA\Property(property: 'current_password', type: 'string', format: 'password', example: 'oldpassword123'),
                    new OA\Property(property: 'new_password', type: 'string', format: 'password', example: 'newpassword123'),
                    new OA\Property(property: 'new_password_confirmation', type: 'string', format: 'password', example: 'newpassword123')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Password changed successfully'),
            new OA\Response(response: 400, description: 'Invalid current password'),
            new OA\Response(response: 422, description: 'Validation Error')
        ]
    )]
    public function changePassword(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->sendError('Invalid Password', ['current_password' => ['The current password does not match nuestro record.']], 400);
        }

        $user->update([
            'password' => $request->new_password
        ]);

        return $this->sendResponse([], 'Password changed successfully.');
    }
}
