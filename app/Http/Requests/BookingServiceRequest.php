<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingServiceRequest extends FormRequest
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
        $checkRerequiredData = 'nullable';

        if (request()->address) {
            $checkRerequiredData = 'required';
        }
        return [
            'service_id' => 'required|integer|exists:services,id',
            'hint' => 'nullable|string',
            'coupon' => 'nullable|string|exists:coupons,coupon',
            // 'as_soon_as' => 'required|boolean',
            'come_to_address_date' => 'nullable|string',
            'booking_at' => 'nullable|date|after:' . now(),
            'quantity' => 'nullable|integer',
            'delivery_car' => 'required|boolean',
            'address' => 'nullable|array',
            'address.address' =>  "$checkRerequiredData|min:5",
            'address.latitude' => "$checkRerequiredData|numeric",
            'address.longitude' => "$checkRerequiredData|numeric",
            'address.description' => 'nullable|string|min:5',        ];
    }
}