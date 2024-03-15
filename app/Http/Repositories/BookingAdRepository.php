<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\BookingAdInterface;
use App\Models\BookingAd;
use App\Services\BookingAdService;
use App\Services\ImageService;
use Carbon\Carbon;

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

        $bookingAds = $garage->bookingAds()->with('media', 'cars:id,name')->get();

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
            'data' => $bookingAd->load('media', 'cars:id,name'),
        ]);
    }

    public function store($request)
    {
        $garage = auth()->user();
        $data = $request->validated();
        $data['garage_id'] = $garage->id;
        $data['amount'] = $this->bookingAdService->calculateAmount($data);

        if (!$garage->wallet) {
            return response()->json(['message' => 'You do not have a wallet'], 400);
        } elseif ($this->bookingAdService->checkSufficientBalance($garage, $data['amount'])) {
            return response()->json(['message' => 'Insufficient balance in the wallet'], 400);
        }


        $this->bookingAdService->updateWalletBalance($garage, -$data['amount']);
        $bookingAd = BookingAd::create($data);
        $bookingAd->media()->create([
            'type' => 'ad',
            'image' => $this->imageService->store($data['image'], 'ads', 'Ad')
        ]);

        $bookingAd->cars()->attach($data['car_ids']);

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
        } elseif ($bookingAd->status != 0 && $bookingAd->status != 1) {
            return response()->json(['message' => 'You can not update this ad'], 400);
        }

        $data = $request->validated();
        // $data['amount'] = $this->bookingAdService->calculateAmount($data);

        // $this->bookingAdService->updateWalletBalance($garage, $bookingAd->amount);
        // if ($this->bookingAdService->checkSufficientBalance($garage, $data['amount'])) {
        //     return response()->json(['message' => 'Insufficient balance in the wallet'], 400);
        // }
        // $this->bookingAdService->updateWalletBalance($garage, -$data['amount']);

        $bookingAd->update($data);
        if ($request->hasFile('image')) {
            $bookingAd->media()->updateOrCreate([
                'type' => 'ad'
            ], [
                'image' => $this->imageService->update($bookingAd->media()->first()?->imageName(), $request->image, 'ads', 'Ad')
            ]);
        }

        $bookingAd->cars()->sync($data['car_ids']);

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => $bookingAd->load('media'),
        ]);
    }

    public function refund($bookingAd)
    {
        $garage = auth()->user();

        if ($garage->id != $bookingAd->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } elseif ($bookingAd->status != 2) {
            return response()->json(['message' => 'You can not refund this ad'], 400);
        }

        $this->bookingAdService->updateWalletBalance($garage, $bookingAd->amount);
        $bookingAd->update(['status' => 3]);
        // $this->imageService->delete($bookingAd->media()->first()?->imageName(), 'ads');
        // $bookingAd->delete();

        return response()->json([
            'success' => true,
            'message' => 'Refunded successfully',
        ]);
    }

    public function userBookingAds()
    {
        /** @var User */
        $user = auth()->user();
        if (isset($user)) {
            $user->load('user_information', 'carLicense');

            $bookingAds = BookingAd::adsForUser($user);
        } else {
            $bookingAds = BookingAd::adsForGuest();
        }

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $bookingAds,
        ]);
    }
}
