<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\CouponInterface;
use App\Models\Coupon;

class CouponRepository implements CouponInterface
{
    public function index()
    {
        $coupons = Coupon::paginate(10);
        return view('coupons.index', ['dataTable' => $coupons]);
    }
}