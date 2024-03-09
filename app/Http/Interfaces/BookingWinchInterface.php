<?php

namespace App\Http\Interfaces;

interface BookingWinchInterface
{
    public function getBookingForWinch($filter_key);
    public function bookingWinch($request);
    public function updateBookingStatusFromWinch($request, $booking_id);
    public function cancelBookingWinchFromUser($booking_id);
    public function doneStatusFromUser($booking_id);
    public function showBookingWinch($booking_id);
    public function getWinchsInUser();


    // public function getBookingsInUser();
    // public function success($request);
    // public function payBookingSerivice($request, $service_id);
    // public function cancelBooking($booking_id);


    // public function showBooking($booking_id);


    // public function getBookingsInGarage();
    // public function updateBookingServiceFromGarage($request, $booking_id);
}
