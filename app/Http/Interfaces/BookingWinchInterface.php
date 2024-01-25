<?php

namespace App\Http\Interfaces;

interface BookingWinchInterface
{
    public function getBookingForWinch();
    public function bookingWinch($request);
    public function updateBookingStatusFromWinch($request, $booking_id);
    public function cancelBookingWinchFromUser($booking_id);

    
    // public function getBookingsInUser();
    // public function success($request);
    // public function payBookingSerivice($request, $service_id);
    // public function cancelBooking($booking_id);


    // public function showBooking($booking_id);


    // public function getBookingsInGarage();
    // public function updateBookingServiceFromGarage($request, $booking_id);
}
