<?php

namespace App\Http\Interfaces;

interface BookingServiceInterface
{
    public function bookingService($request);
    public function getBookingsInUser($filter_key);
    public function success($request);
    public function payBookingSerivice($request, $service_id);
    public function cancelBooking($booking_id);
    public function onTheWayFromUser($booking_id);


    public function showBooking($booking_id);


    public function getBookingsInGarage($filter_key);
    public function updateBookingServiceFromGarage($request, $booking_id);
}
