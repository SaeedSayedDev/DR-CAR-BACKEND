<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //

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
            'notification_count' => Notification::where('user_id', $user->id)->where('read',0)->get()->count(),
            "message" => "Notifications count retrieved successfully"

        ]);
    }
    

    public function update($notification_id)
    {
        $user = auth()->user();
        $notification =  Notification::where('user_id', $user->id)->find($notification_id);
        $notification->update(['read' => 1]);
        return response()->json([
            'success' => true,
            'data' => $notification,
            "message" => "Notifications retrieved successfully"

        ]);
    }
}
