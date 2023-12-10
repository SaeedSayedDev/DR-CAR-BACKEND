<?php

namespace App\Http\Interfaces;

interface BookingServiceInterface
{
    public function bookingService($request);
    public function payBookingSerivice($request, $service_id);
    public function success($request);
}
