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
            'eProviders' => GarageData::take(2)->get(),
            'bookings' => BookingService::all()->concat(BookingWinch::all())->take(5),
        ];
        return view('dashboard.index', $stats);
    }

    private function totalBookings()
    {
        return number_format(
            BookingService::where('payment_stataus', 'paid')->get()->sum('payment_amount')
                + BookingWinch::where('payment_stataus', 'paid')->get()->sum('payment_amount'),
            2,
            '.',
            ''
        );
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
