<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('user:id,full_name')->paginate(10);

        return view('notifications.index', ['dataTable' => $notifications]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->back();
    }
}
