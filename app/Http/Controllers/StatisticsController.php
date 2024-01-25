<?php

namespace App\Http\Controllers;

use App\Models\Admin\Service;
use App\Models\BookingService;
use App\Models\BookingWinch;
use App\Models\Wallet;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function statistics()
    {
        $user = auth()->user();
        $total_earning = Wallet::where('user_id', $user->id)->first();

        if ($user->role_id == 4) {
            $toltal_bookings = BookingService::whereHas('serviceProvider', function ($query) {
                $query->where('provider_id', auth()->user()->garage_data->id);
            })
                ->with('serviceProvider.media', 'serviceProvider.provider')
                ->get()->count();
            $total_services = Service::where('provider_id', auth()->user()->garage_data->id)->get()->count();
            return response()->json([
                'success' => true,
                'toltal_bookings' =>  $toltal_bookings,
                'total_earning' =>  $total_earning->total_earning,
                'total_services' =>  $total_services,
                "message" => "statistics retrieved successfully"
            ]);
        } elseif ($user->role_id == 3) {
            $toltal_bookings = BookingWinch::where('winch_id', $user->id)->get()->count();
            return response()->json([
                'success' => true,
                'toltal_bookings' =>  $toltal_bookings,
                'total_earning' =>  $total_earning,
                "message" => "statistics retrieved successfully"
            ]);
        }
    }
}
