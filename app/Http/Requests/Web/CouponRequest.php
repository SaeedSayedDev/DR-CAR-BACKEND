<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'start_date' => "required",
            'end_date' => "required|after:start_date",
            'coupon' => 'required|string|unique:coupons,coupon,' . $this->route('coupon'),
            'coupon_unit' => 'required|boolean',
            'coupon_price' => 'required|string',
            'provider_id' => 'required|exists:users,id',
        ];
    }
}
