<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BookingAd;
use Illuminate\Http\Request;

class BookingAdController extends Controller
{
    public function index()
    {
        $bookingAds = BookingAd::with('garage:id,full_name')->paginate(10);

        return view('booking_ads.index', ['dataTable' => $bookingAds]);
    }

    public function show(BookingAd $bookingAd)
    {
        return view('booking_ads.show', ['booking_ad' => $bookingAd]);
    }

    public function approve(BookingAd $bookingAd)
    {
        $data = [
            'status' => 1,
            'display' => true,
            'display_start_date' => now()->toDateString(),
            'display_end_date' => now()->addDays($bookingAd->display_duration)->toDateString(),
        ];

        $bookingAd->update($data);

        return  redirect()->route('booking-ads.index')->with('success', 'Booking ad has been approved');
    }

    public function reject(Request $request, BookingAd $bookingAd)
    {
        $data = $request->validate(['rejection_reason' => 'nullable|string']);
        $data['status'] = 2;

        $bookingAd->update($data);

        return  redirect()->route('booking-ads.index')->with('success', 'Booking ad has been rejected');
    }
}
