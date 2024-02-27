<?php

namespace App\Services;

use App\Models\BookingAd;
use App\Models\Coupon;
use App\Models\User;

class BookingAdService
{
    public function __construct(Private ImageService $imageService)
    {
    }

    public function create($request, $garage)
    {
        $data = $request->validated();
        $data['garage_id'] = $garage->id;
        $data['amount'] = $this->calculateAmount($data);

        if ($this->checkSufficientBalance($garage, $data['amount'])) {
            return response()->json(['message' => 'Insufficient balance in the wallet'], 400);
        }

        $this->updateWalletBalance($garage, -$data['amount']);

        if ($data['format'] == 1) {
            unset($data['text']);
        }

        $bookingAd = BookingAd::create($data);
        
        if ($data['format'] == 1) {
            $this->imageService->storeMedia($request, $bookingAd->id, 'booking_ad', 'public/images/ads', url("api/images/Ad/"));
        }

        return $bookingAd;
    }

    public function update($request, $bookingAd, $garage)
    {
        $data = $request->validated();
        $data['amount'] = $this->calculateAmount($data);

        $this->updateWalletBalance($garage, $bookingAd->amount);
        if ($this->checkSufficientBalance($garage, $data['amount'])) {
            return response()->json(['message' => 'Insufficient balance in the wallet'], 400);
        }
        $this->updateWalletBalance($garage, -$data['amount']);

        if ($data['format'] == 1) {
            $data['text'] = null;
            $this->imageService->storeMedia($request, $bookingAd->id, 'booking_ad', 'public/images/ads', url("api/images/Ad/"));
        } elseif ($data['format'] == 0) {
            $this->imageService->deleteMedia($bookingAd->id, 'booking_ad', 'public/images/ads', '');
        }

        $bookingAd->update($data);

        return $bookingAd;
    }

    public function delete($bookingAd, $garage)
    {
        $this->updateWalletBalance($garage, $bookingAd->amount);
        $this->imageService->deleteMedia($bookingAd->id, 'booking_ad', 'public/images/ads', '');
        $bookingAd->delete();
    }

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
