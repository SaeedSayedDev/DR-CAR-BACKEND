<?php

namespace App\Http\Interfaces;

interface BookingAdInterface
{
    public function index();
    public function show($bookingAd);
    public function store($request);
    public function update($request, $bookingAd);
    public function refund($bookingAd);
    public function userBookingAds();
}
