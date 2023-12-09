<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (request()->isMethod('post')) {
            return [
                'start_date' => "required|date_format:Y/m/d",
                'end_date' => "required|date_format:Y/m/d|after:start_date",
                'coupon' => 'required|string|unique:coupons',
                'coupon_unit' => 'required|boolean',/* (fixed =>0 , percentage=>1) */
                'coupon_price' => 'required|string'
            ];
        }
        if (request()->isMethod('put')) {
            $id =  request()->route('id');
            return [
                'start_date' => "required|date_format:Y/m/d",
                'end_date' => "required|date_format:Y/m/d|after:start_date",
                'coupon' => "required|string|unique:coupons,coupon,$id",
                'coupon_unit' => 'required|boolean',/* (fixed =>0 , percentage=>1) */
                'coupon_price' => 'required|string'
            ];
        }
    }
}
