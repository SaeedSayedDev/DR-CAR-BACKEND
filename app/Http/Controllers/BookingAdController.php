<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingAdRequest;
use App\Models\BookingAd;
use App\Models\Coupon;
use App\Services\ImageService;

class BookingAdController extends Controller
{
    private $garage, $dayPrice;

    public function __construct(private ImageService $imageService)
    {
        $this->garage = auth()->user();
        if (!$this->garage || $this->garage->role_id !== 4) {
            abort(403, 'Unauthorized');
        }
        $this->dayPrice = 10;
    }

    public function index()
    {
        $bookingAds = $this->garage->bookingAds;

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $bookingAds,
        ]);
    }

    public function show(BookingAd $bookingAd)
    {
        if ($this->garage->id !== $bookingAd->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $bookingAd,
        ]);
    }

    public function store(BookingAdRequest $request)
    {
        $data = $request->validated();
        $data['garage_id'] = $this->garage->id;
        if ($data['format'] == 1) {
            unset($data['text']);
        }
        $discount = isset($data['coupon']) ? Coupon::where('coupon', $data['coupon'])->first()->coupon_price : 0;
        $data['amount'] = $data['display_duration'] * $this->dayPrice - $discount;
        // TODO: payment

        $bookingAd = BookingAd::create($data);
        if ($data['format'] == 1) {
            $this->imageService->storeMedia($request, $bookingAd->id, 'booking_ad', 'public/images/ads', url("api/images/Ad/"));
        }

        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $bookingAd,
        ], 201);
    }

    public function update(BookingAdRequest $request, BookingAd $bookingAd)
    {
        if ($this->garage->id !== $bookingAd->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validated();
        if ($data['format'] == 1) {
            $data['text'] = null;
        } elseif ($data['format'] == 0) {
            $this->imageService->deleteMedia($bookingAd->id, 'booking_ad', 'public/images/ads', url("api/images/Ad/"));
        }
        $discount = isset($data['coupon']) ? Coupon::where('coupon', $data['coupon'])->first()->coupon_price : 0;
        $data['amount'] = $data['display_duration'] * $this->dayPrice - $discount;
        // TODO: payment

        $bookingAd->update($data);
        if ($data['format'] == 1) {
            $this->imageService->storeMedia($request, $bookingAd->id, 'booking_ad', 'public/images/ads', url("api/images/Ad/"));
        }

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => $bookingAd,
        ]);
    }
}
