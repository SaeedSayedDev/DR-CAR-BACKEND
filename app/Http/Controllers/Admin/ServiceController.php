<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Admin\ServiceInterface;
use App\Http\Interfaces\BookingServiceInterface;
use App\Http\Interfaces\CouponInterface;
use App\Http\Interfaces\OptionInterface;
use App\Http\Requests\Admin\ServiceRequest;
use App\Http\Requests\BookingServiceRequest;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\OPtionRequest;
use App\Http\Requests\payBookingSeriviceRequest;
use App\Http\Requests\UpdateBookingServiceRequest;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(private ServiceInterface $serviceInterface, private BookingServiceInterface $bookingServiceInterface, private CouponInterface $couponInterface, private OptionInterface $optionInterface)
    {
    }

    public function index()
    {
        return $this->serviceInterface->index();
    }
    public function servicesProvider($provider_id)
    {
        return $this->serviceInterface->servicesProvider($provider_id);
    }
    public function indexGarage()
    {
        return $this->serviceInterface->indexGarage();
    }
    public function store(ServiceRequest $request)
    {
        return $this->serviceInterface->store($request);
    }
    public function show(string $id)
    {
        return $this->serviceInterface->show($id);
    }
    public function update(ServiceRequest $request, string $id)
    {
        return $this->serviceInterface->update($request, $id);
    }
    public function delete(string $id)
    {
        return $this->serviceInterface->delete($id);
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




    // Coupon 
    public function indexCoupon()
    {
        return $this->couponInterface->index();
    }
    public function storeCoupon(CouponRequest $request)
    {
        return $this->couponInterface->store($request);
    }
    public function showCoupon($coupon_id)
    {
        return $this->couponInterface->show($coupon_id);
    }
    public function updateCoupon(CouponRequest $request,  $coupon_id)
    {
        return $this->couponInterface->update($request, $coupon_id);
    }
    public function deleteCoupon($coupon_id)
    {
        return $this->couponInterface->delete($coupon_id);
    }



    //options 
    public function storeOPtion(OptionRequest $request)
    {
        return $this->optionInterface->store($request);
    }
    public function updateOption(OptionRequest $request,  $OPtion_id)
    {
        return $this->optionInterface->update($request, $OPtion_id);
    }
}