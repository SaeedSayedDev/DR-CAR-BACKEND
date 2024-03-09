<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\CouponInterface;
use App\Http\Requests\Web\CouponRequest;

class CouponController extends Controller
{
    public function __construct(private CouponInterface $couponInterface)
    {
    }

    public function index()
    {
        return $this->couponInterface->index();
    }

    public function create()
    {
        return $this->couponInterface->create();
    }

    public function store(CouponRequest $request)
    {
        return $this->couponInterface->store($request);
    }

    public function edit(string $id)
    {
        return $this->couponInterface->edit($id);
    }

    public function update(CouponRequest $request, string $id)
    {
        return $this->couponInterface->update($request, $id);
    }

    // public function destroy(string $id)
    // {
    //     return $this->couponInterface->destroy($id);
    // }
}
