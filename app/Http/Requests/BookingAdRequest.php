<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingAdRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'display_duration' => 'required|integer|min:1',
            'format' => 'required|boolean',
            'text' => 'required_if:format,0|string',
            'images' => 'required_if:format,1|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'nullable|boolean',
            'coupon' => 'nullable|string|exists:coupons,coupon',

            'car_type' => 'required|string',
            'car_start_date' => 'required|date_format:Y',
            'car_end_date' => 'required|date_format:Y',
        ];
    }
}
