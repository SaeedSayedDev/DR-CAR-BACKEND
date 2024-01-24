<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\CouponInterface;

class CouponController extends Controller
{
    public function __construct(private CouponInterface $couponInterface)
    {
    }

    public function __invoke()
    {
        return $this->couponInterface->index();
    }
}
