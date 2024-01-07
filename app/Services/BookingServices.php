<?php

namespace App\Services;

use App\Models\Address;
use App\Models\BookingService;
use App\Models\Coupon;

class BookingServices
{
    function updateBooking($booking, $payment_type, $payment_id)
    {
        return  $booking->update(
            [
                'payment_type' => $payment_type,
                'payment_stataus' => 'paid',
                'payment_id' => $payment_id,
            ]
        );
    }
    function priceBooking($request, $service)
    {
        $price = $service->discount_price >= 1 ? $service->discount_price : $service->price;
        if (isset($request->quantity) > 0 and $service->price_unit == 1)
            $service_price = $price * $request->quantity;
        else
            $service_price = $price;


        if (isset($request->coupon)) {
            $coupon = Coupon::where('coupon', $request->coupon)->where('provider_id', $service->provider->garage_id)->first();
            if ($coupon->coupon_unit == 0)
                $service_price = $service_price - $coupon->coupon_price;
            elseif ($coupon->coupon_unit == 1)
                $service_price = $service_price - $coupon->coupon_price / 100 * $service_price;
        }
        return $service_price;
    }
    function bookingData($request, $service_price)
    {
        $requestData = $request->all();
        unset($requestData['address']);

        $requestData['payment_amount'] = $service_price;
        $requestData['user_id'] = auth()->user()->id;
        // dd($requestData);
        return BookingService::create($requestData);
    }

    function addressBooking($request)
    {

        if (isset($request['address'])) {
            $data = $request['address'];
            $data['user_id'] =  auth()->id();

            $Address = Address::updateOrCreate(['user_id' => auth()->id()], $data);
            dd($Address);
        }
    }
}