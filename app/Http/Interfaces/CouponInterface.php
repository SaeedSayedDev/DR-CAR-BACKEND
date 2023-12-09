<?php

namespace App\Http\Interfaces;


interface CouponInterface
{

    public function index();
    public function show($coupon_id);
    public function store($request);
    public function update($request, $coupon_id);
    public function delete($coupon_id);
}
