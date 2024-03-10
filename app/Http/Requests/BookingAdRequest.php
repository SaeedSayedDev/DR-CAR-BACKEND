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
        $rules = [
            'text' => 'required_if:format,0|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'nullable|in:0,1,2',

            'car_type' => 'required|exists:cars,id',
            'car_start_date' => 'required|date_format:Y',
            'car_end_date' => 'required|date_format:Y',
        ];

        if ($this->isMethod('post')) {
            $rules['display_duration'] = 'required|integer|min:1';
            $rules['coupon'] = 'nullable|string|exists:coupons,coupon';
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $rules;
    }
}
