<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\BookingAdInterface;
use App\Http\Interfaces\BookingServiceInterface;
use App\Http\Interfaces\BookingWinchInterface;
use App\Http\Requests\BookingAdRequest;
use App\Http\Requests\BookingServiceRequest;
use App\Http\Requests\BookingWinchRequest;
use App\Http\Requests\payBookingSeriviceRequest;
use App\Http\Requests\PaypalSeuccessRequest;
use App\Http\Requests\UpdateBookingServiceRequest;
use App\Http\Requests\updateBookingWinchRequest;
use App\Models\BookingAd;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        private BookingServiceInterface $bookingServiceInterface,
        private BookingWinchInterface $bookingWinchInterface,
        private BookingAdInterface $bookingAdInterface
    ) {
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

    public function getBookingsInUser($filter_key)
    {
        return $this->bookingServiceInterface->getBookingsInUser($filter_key);
    }
    public function cancelBooking($booking_id)
    {
        return $this->bookingServiceInterface->cancelBooking($booking_id);
    }



    public function getBookingsInGarage($filter_key)
    {
        return $this->bookingServiceInterface->getBookingsInGarage($filter_key);
    }

    public function showBooking($booking_id)
    {
        return $this->bookingServiceInterface->showBooking($booking_id);
    }


    public function updateBookingServiceFromGarage(UpdateBookingServiceRequest $request, $booking_id)
    {
        return $this->bookingServiceInterface->updateBookingServiceFromGarage($request, $booking_id);
    }


    public function onTheWayFromUser($booking_id)
    {
        return $this->bookingServiceInterface->onTheWayFromUser($booking_id);
    }


    public function success(PaypalSeuccessRequest $request)
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

    public function cancelBookingWinchFromUser($booking_id)
    {
        return $this->bookingWinchInterface->cancelBookingWinchFromUser($booking_id);
    }

    public function updateBookingStatusFromWinch(updateBookingWinchRequest $request, $booking_id)
    {
        return $this->bookingWinchInterface->updateBookingStatusFromWinch($request, $booking_id);
    }
    public function doneStatusFromUser($booking_id)
    {
        return $this->bookingWinchInterface->doneStatusFromUser($booking_id);
    }
    public function getBookingForWinch($filter_key)
    {
        return $this->bookingWinchInterface->getBookingForWinch($filter_key);
    }

    public function showBookingWinch($booking_id)
    {
        return $this->bookingWinchInterface->showBookingWinch($booking_id);
    }

    public function getWinchsInUser()
    {
        return $this->bookingWinchInterface->getWinchsInUser();
    }



    # Booking Ad

    public function indexBookingAds()
    {
        return $this->bookingAdInterface->index();
    }

    public function showBookingAd(BookingAd $bookingAd)
    {
        return $this->bookingAdInterface->show($bookingAd);
    }

    public function storeBookingAd(BookingAdRequest $request)
    {
        return $this->bookingAdInterface->store($request);
    }

    public function updateBookingAd(BookingAdRequest $request, BookingAd $bookingAd)
    {
        return $this->bookingAdInterface->update($request, $bookingAd);
    }

    public function refundBookingAd(BookingAd $bookingAd)
    {
        return $this->bookingAdInterface->refund($bookingAd);
    }

    public function userBookingAds()
    {
        return $this->bookingAdInterface->userBookingAds();
    }
}
