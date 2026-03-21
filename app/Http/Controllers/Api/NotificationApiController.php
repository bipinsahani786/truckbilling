<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class NotificationApiController extends BaseController
{
    #[OA\Get(
        path: '/api/notifications',
        tags: ['Notifications'],
        summary: 'Get user notifications',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Notifications retrieved successfully')
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $notifications = $request->user()->notifications()->paginate(20);
        return $this->sendResponse($notifications, 'Notifications retrieved successfully.');
    }

    #[OA\Post(
        path: '/api/notifications/{id}/read',
        tags: ['Notifications'],
        summary: 'Mark a notification as read',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Notification marked as read'),
            new OA\Response(response: 404, description: 'Notification not found')
        ]
    )]
    public function markAsRead(Request $request, $id): JsonResponse
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return $this->sendResponse([], 'Notification marked as read.');
    }

    #[OA\Post(
        path: '/api/notifications/read-all',
        tags: ['Notifications'],
        summary: 'Mark all notifications as read',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'All notifications marked as read')
        ]
    )]
    public function readAll(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();
        return $this->sendResponse([], 'All notifications marked as read.');
    }
}
