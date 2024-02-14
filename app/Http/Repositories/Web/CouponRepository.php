<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\CouponInterface;
use App\Models\Coupon;
use App\Models\User;

class CouponRepository implements CouponInterface
{
    public function index()
    {
        $coupons = Coupon::paginate(10);
        return view('coupons.index', ['dataTable' => $coupons]);
    }

    public function create()
    {
        $eProvider = User::where('role_id', 4)->pluck('full_name', 'id')->toArray();

        return view('coupons.create', compact('eProvider'));
    }
    
    public function store($request)
    {
        $validatedData = $request->validated();
        if (User::find($request->provider_id)->role_id != 4) return back();
        
        Coupon::create($validatedData);

        return redirect()->route('coupons.index');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $eProvider = User::where('role_id', 4)->pluck('full_name', 'id')->toArray();

        return view('coupons.edit', compact('coupon', 'eProvider'));
    }

    public function update($request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $validatedData = $request->validated();

        $coupon->update($validatedData);

        return redirect()->route('coupons.index');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->delete();

        return redirect()->route('coupons.index');
    }
}