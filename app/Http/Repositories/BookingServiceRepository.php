<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\BookingServiceInterface;
use App\Http\Interfaces\FavouriteInterface;
use App\Models\Admin\Service;
use App\Models\BookingService;
use App\Models\Coupon;
use App\Models\Favourite;
use App\Models\User;

class BookingServiceRepository implements BookingServiceInterface
{


    public function bookingService($request)
    {
        $service =  Service::where('enable_booking', true)->find($request->service_id);
        if (isset($request->quantity) and $service->price_unit == 1)
            $service_price = $service->discount_price * $request->quantity;
        else
            $service_price = $service->discount_price;
        if (isset($request->coupon)) {
            $coupon = Coupon::where('coupon', $request->coupon)->where('provider_id', $service->provider_id)->first();
            if ($coupon->coupon_unit == 0)
                $service_price_after_coupon = $service_price - $coupon->coupon_price;
            elseif ($coupon->coupon_unit == 1)
                $service_price_after_coupon = $service_price - $coupon->coupon_price / 100 * $service_price;
        }
        $requestData = $request->all();
        $requestData['payment_amount'] = $service_price_after_coupon;
        $requestData['user_id'] = auth()->user()->id;
        BookingService::create($requestData);
        return response()->json(['message' => 'success']);
    }
}
