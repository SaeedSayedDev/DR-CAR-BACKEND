<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageNotificationRequest;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    public function index()
    {
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'data' => Notification::where('user_id', $user->id)->get(),
            "message" => "Notifications retrieved successfully"

        ]);
    }

    public function notificationCount()
    {
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'data ' => ['notification_count' => Notification::where('user_id', $user->id)->where('read', 0)->get()->count()],
            "message" => "Notifications count retrieved successfully"

        ]);
    }


    public function update($notification_id)
    {
        $user = auth()->user();
        $notification =  Notification::where('user_id', $user->id)->findOrFail($notification_id);
        $notification->update(['read' => 1]);
        return response()->json([
            'success' => true,
            'data' => $notification,
            "message" => "Notifications retrieved successfully"

        ]);
    }
    public function delete($notification_id)
    {
        $user = auth()->user();
        Notification::where('user_id', $user->id)->findOrFail($notification_id)->delete();
        return response()->json([
            'success' => true,
            "message" => "Notification deleted successfully"

        ]);
    }

    public function messageNotification(MessageNotificationRequest $request)
    {
        $user = auth()->user();
        $type_id = 0;
        $creator_name = $user->full_name;
        $reciver_id = $request->user_id;
        $notification_type_en = 'message';
        $notification_type_ar = 'رسالة';
        $text_en = $user->full_name . 'sent a new message';
        $text_ar = $user->full_name . 'ارسل لك رسالة جديدة ';
        $api = 'message api';


        $this->notificationService->notification($type_id, $creator_name,  $text_en, $text_ar, $notification_type_en, $notification_type_ar, $api, $reciver_id);
        return response()->json([
            'success' => true,
            "message" => "notification send successfully"
        ]);
    }
}
