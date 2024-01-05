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
            'data' => Notification::where('user_id', $user->id)->get()
        ]);
    }
}