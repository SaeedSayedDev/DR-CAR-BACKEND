<?php

namespace App\Services;

use App\Models\Coupon;

class BookingAdService
{
    public function calculateAmount($data)
    {
        $dayPrice = 10;
        $discount = isset($data['coupon']) ? Coupon::where('coupon', $data['coupon'])->first()->coupon_price : 0;
        return $data['display_duration'] * $dayPrice - $discount;
    }

    public function checkSufficientBalance($garage, $amount)
    {
        return $garage->wallet->total_balance < $amount;
    }

    public function updateWalletBalance($garage, $amount)
    {
        $wallet = $garage->wallet;
        $wallet->total_balance += $amount;
        $wallet->save();
    }
}
