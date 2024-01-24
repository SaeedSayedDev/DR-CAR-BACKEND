<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\DashboardInterface;
use App\Models\BookingService;
use App\Models\BookingWinch;
use App\Models\GarageData;
use App\Models\User;

class DashboardRepository implements DashboardInterface
{
    public function index()
    {
        $stats = [
            'total_bookings' => $this->totalBookings(),
            'total_earnings' => $this->totalEarnings(),
            'count_providers' => GarageData::count(),
            'count_customers' => User::where('role_id', 2)->count(),
            'eProviders' => GarageData::take(5)->get(),
            'bookings' => BookingService::all()->concat(BookingWinch::all())->take(5),
        ];
        return view('dashboard.index', $stats);
    }

    private function totalBookings()
    {
        return BookingService::all()->sum(function ($booking_service) {
            return $booking_service->payment_amount * $booking_service->quantity;
        }) + BookingWinch::sum('payment_amount');
    }

    private function totalEarnings()
    {
        return BookingService::all()->sum(function ($booking_service) {
            $total = $booking_service->payment_amount * $booking_service->quantity;
            if ($booking_service->payment_type) {
                return $total + $booking_service->taxes;
            } else {
                return $total + ($total * $booking_service->taxes / 100);
            }
        }) + BookingWinch::sum('payment_amount');
    }
}