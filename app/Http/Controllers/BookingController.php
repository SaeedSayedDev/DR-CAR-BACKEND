<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\BookingServiceInterface;
use App\Http\Interfaces\BookingWinchInterface;
use App\Http\Requests\BookingServiceRequest;
use App\Http\Requests\BookingWinchRequest;
use App\Http\Requests\payBookingSeriviceRequest;
use App\Http\Requests\UpdateBookingServiceRequest;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingServiceInterface $bookingServiceInterface,private BookingWinchInterface $bookingWinchInterface)
    {
    }

    // Booking service
    public function bookingService(BookingServiceRequest $request)
    {
        return $this->bookingServiceInterface->bookingService($request);
    }
    public function payBookingSerivice(payBookingSeriviceRequest $request, $service_id)
    {
        return $this->bookingServiceInterface->payBookingSerivice($request, $service_id);
    }

    public function getBookingsInUser()
    {
        return $this->bookingServiceInterface->getBookingsInUser();
    }
    public function cancelBooking($booking_id)
    {
        return $this->bookingServiceInterface->cancelBooking($booking_id);
    }


    public function getBookingsInGarage()
    {
        return $this->bookingServiceInterface->getBookingsInGarage();
    }

    public function showBooking($booking_id)
    {
        return $this->bookingServiceInterface->showBooking($booking_id);
    }


    public function updateBookingServiceFromGarage(UpdateBookingServiceRequest $request, $booking_id)
    {
        return $this->bookingServiceInterface->updateBookingServiceFromGarage($request, $booking_id);
    }


    public function success(Request $request)
    {
        return $this->bookingServiceInterface->success($request);
    }
    public function error()
    {
        return 'User declined the payment!';
    }

    // Booking Winch
    public function bookingWinch(BookingWinchRequest $request)
    {
        return $this->bookingWinchInterface->bookingWinch($request);
    }
    
}
