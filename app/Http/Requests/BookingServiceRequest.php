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
        return [
            'service_id' => 'required|integer|exists:services,id',
            'address_id' => 'required|integer|exists:addresses,id',
            'hint' => 'nullable|string',
            'coupon' => 'nullable|string|exists:coupons,coupon',
            'as_soon_as' => 'required|boolean',
            'come_to_address_date' => 'required_if:as_soon_as,==,1|string',
            'quantity' => 'nullable|integer',
            'delivery_car' => 'required|boolean'

        ];
    }
}
