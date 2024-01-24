<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\BookingServiceInterface;
use App\Models\BookingService;

class BookingServiceRepository implements BookingServiceInterface
{
    public function index()
    {
        $booking_service = BookingService::paginate(10);
        return view('booking_service.index', ['dataTable' => $booking_service]);
    }
}