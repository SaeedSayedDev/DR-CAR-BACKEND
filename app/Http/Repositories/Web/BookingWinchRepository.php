<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\BookingWinchInterface;
use App\Models\BookingWinch;

class BookingWinchRepository implements BookingWinchInterface
{
    public function index()
    {
        $booking_winch = BookingWinch::with([
            'user:id,full_name', 'winch:id,full_name','bookingService.service:id,name', 'address:id,address'
        ])->paginate(10);

        return view('booking_winch.index', ['dataTable' => $booking_winch]);
    }
}