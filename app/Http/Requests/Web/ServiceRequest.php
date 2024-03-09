<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|required|max:255',
            'desc' => 'string|nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'numeric|required',

            'discount_price' => 'numeric|nullable',
            'price_unit' => 'string|nullable',
            'quantity_unit' => 'string|nullable',
            'duration' => 'string|nullable',
            'featured' => 'boolean',
            'enable_booking' => 'boolean',
            'provider_id' => 'integer|required',
            'available' => 'boolean',
        ];
    }
}
