<?php

namespace App\Services;

use App\Models\Address;
use App\Models\BookingService;
use App\Models\Commission;
use App\Models\Coupon;
use App\Models\Taxe;

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

        $tax_price =  $this->servicePricePlusTax($price, $service->provider->tax_id);

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
        return $service_price + $tax_price;
    }

    public function servicePricePlustax($price, $tax_id)
    {
        $tax = Taxe::find($tax_id);
        if ($tax->type == 1) {
            return ($tax->value / 100 * $price);
        } else {
            return   $tax->value;
        }
    }


    public function commissionForPayment($service_price)
    {
        $commission = Commission::first();
        if ($commission->commission_from == 0) {
            if ($commission->type == 1)
                $service_price += ($commission->commission / 100 * $service_price);
            elseif ($commission->type == 0)
                $service_price += $commission->commission;
        }
        return $service_price;
    }

    public function commissionNet($payment_amount, $net)
    {
        $commission = Commission::first();
        if ($commission->commission_from == 0 and $commission->type == 1) {
            $netAftercommission = $net - ($commission->commission / (100 + $commission->commission) * $payment_amount);
        } elseif ($commission->commission_from == 1 and $commission->type == 1) {
            $netAftercommission = $net - ($commission->commission / 100 * $payment_amount);
        } else {
            $netAftercommission = $net - $commission->commission;
        }
        return $netAftercommission;
        // return $service_price;
        // 100 -> 120 ->132
    }


    function bookingData($request, $service_price)
    {
        $requestData = $request->all();
        unset($requestData['address']);

        $requestData['payment_amount'] = $service_price;
        $requestData['user_id'] = auth()->user()->id;
        return BookingService::create($requestData);
    }

    function addressBooking($request)
    {

        if (isset($request['address'])) {
            $data = $request['address'];
            $data['user_id'] =  auth()->user()->id;

            Address::updateOrCreate(['user_id' => auth()->id()], $data);
        }
    }

    public function netDivision($delivery_car, $bookingServiceAmount, $bookingWinchAmount, $net)
    {
        $subtraction = ($bookingServiceAmount + $bookingWinchAmount) - $net;
        $percentage = $subtraction / ($bookingServiceAmount + $bookingWinchAmount) * 100;

        if ($delivery_car == 1)
            $winch_net = $bookingWinchAmount - $percentage / 100 * $bookingWinchAmount;
        else
            $winch_net = 0;

        $garage_net = $bookingServiceAmount - $percentage / 100 * $bookingServiceAmount;
        return ['garage_net' => $garage_net, 'winch_net' => $winch_net];
    }
}
