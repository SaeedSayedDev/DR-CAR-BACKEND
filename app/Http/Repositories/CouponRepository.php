<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\CouponInterface;
use App\Models\Coupon;

class CouponRepository implements CouponInterface
{
    public function index()
    {
        $provider_id = auth()->user()->id;
        $coupons = Coupon::where('provider_id', $provider_id)->get();
        return response()->json(['message' => $coupons]);
    }
    public function show($coupon_id)
    {
        $provider_id = auth()->user()->id;

        $coupon = Coupon::where('provider_id', $provider_id)->findOrFail($coupon_id);
        return response()->json(['message' => $coupon]);
    }

    public function store($request)
    {
        $requestData = $request->all();
        $requestData['provider_id'] = auth()->user()->id;

        Coupon::create($requestData);
        return response()->json(['message' => 'success']);
    }

    public function update($request, $coupon_id)
    {
        $provider_id = auth()->user()->id;
        $coupon = Coupon::where('provider_id', $provider_id)->findOrFail($coupon_id);
        $coupon->update($request->all());
        return response()->json(['message' => 'success']);
    }

    public function delete($coupon_id)
    {
        $provider_id = auth()->user()->id;
        Coupon::where('provider_id', $provider_id)->findOrFail($coupon_id)->delete();
        return response()->json(['message' => 'success']);
    }
}
