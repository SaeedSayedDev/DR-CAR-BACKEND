<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\BookingAdInterface;
use App\Models\BookingAd;
use App\Services\BookingAdService;
use App\Services\ImageService;

class BookingAdRepository implements BookingAdInterface
{
    public function __construct(
        private BookingAdService $bookingAdService,
        private ImageService $imageService
    ) {
    }

    public function index()
    {
        /** @var User */
        $garage = auth()->user();

        $bookingAds = $garage->bookingAds()->with('media')->get();

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $bookingAds,
        ]);
    }

    public function show($bookingAd)
    {
        $garage = auth()->user();

        if ($garage->id != $bookingAd->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $bookingAd->load('media'),
        ]);
    }

    public function store($request)
    {
        $garage = auth()->user();
        $data = $request->validated();
        $data['garage_id'] = $garage->id;
        $data['amount'] = $this->bookingAdService->calculateAmount($data);

        if ($this->bookingAdService->checkSufficientBalance($garage, $data['amount'])) {
            return response()->json(['message' => 'Insufficient balance in the wallet'], 400);
        }

        $this->bookingAdService->updateWalletBalance($garage, -$data['amount']);

        if ($data['format'] == 1) {
            unset($data['text']);
        }

        $bookingAd = BookingAd::create($data);

        if ($data['format'] == 1) {
            $this->imageService->storeMedia($request, $bookingAd->id, 'booking_ad', 'public/images/ads', url("api/images/Ad/"));
        }

        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $bookingAd->load('media'),
        ], 201);
    }

    public function update($request, $bookingAd)
    {
        $garage = auth()->user();

        if ($garage->id != $bookingAd->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validated();
        $data['status'] = 0;
        // $data['amount'] = $this->bookingAdService->calculateAmount($data);

        // $this->bookingAdService->updateWalletBalance($garage, $bookingAd->amount);
        // if ($this->bookingAdService->checkSufficientBalance($garage, $data['amount'])) {
        //     return response()->json(['message' => 'Insufficient balance in the wallet'], 400);
        // }
        // $this->bookingAdService->updateWalletBalance($garage, -$data['amount']);

        if ($data['format'] == 1) {
            $data['text'] = null;
            $this->imageService->storeMedia($request, $bookingAd->id, 'booking_ad', 'public/images/ads', url("api/images/Ad/"));
        } elseif ($data['format'] == 0) {
            $this->imageService->deleteMedia($bookingAd->id, 'booking_ad', 'public/images/ads', '');
        }

        $bookingAd->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => $bookingAd->load('media'),
        ]);
    }

    public function deleteAndRefund($bookingAd)
    {
        $garage = auth()->user();

        if ($garage->id != $bookingAd->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $this->bookingAdService->updateWalletBalance($garage, $bookingAd->amount);
        // $this->imageService->deleteMedia($bookingAd->id, 'booking_ad', 'public/images/ads', '');
        $bookingAd->update(['status' => 3]);
        $bookingAd->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted and refunded successfully',
        ]);
    }

    public function userBookingAds()
    {
        $bookingAds = BookingAd::where('display', true)->with('media')->get();

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $bookingAds,
        ]);
    }
}
