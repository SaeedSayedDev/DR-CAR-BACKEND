<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingAdRequest;
use App\Models\BookingAd;
use App\Models\Coupon;
use App\Services\BookingAdService;
use App\Services\ImageService;

class BookingAdController extends Controller
{
    public function __construct(private BookingAdService $bookingAdService)
    {
    }

    public function index()
    {
        $bookingAds = auth()->user()->bookingAds;

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $bookingAds,
        ]);
    }

    public function show(BookingAd $bookingAd)
    {
       $this->authorize('view', $bookingAd);

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $bookingAd,
        ]);
    }

    public function store(BookingAdRequest $request)
    {
        $bookingAd = $this->bookingAdService->create($request, auth()->user());

        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $bookingAd,
        ], 201);
    }

    public function update(BookingAdRequest $request, BookingAd $bookingAd)
    {
        $this->authorize('update', $bookingAd);

        $bookingAd = $this->bookingAdService->update($request, $bookingAd, auth()->user());

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => $bookingAd,
        ]);
    }

    public function destroyAndRefund(BookingAd $bookingAd)
    {
        $this->authorize('delete', $bookingAd);

        $this->bookingAdService->delete($bookingAd, auth()->user());
        
        return response()->json([
            'success' => true,
            'message' => 'Deleted and refunded successfully',
        ]);
    }
}
