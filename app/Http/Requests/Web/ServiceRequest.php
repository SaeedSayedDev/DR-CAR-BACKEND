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
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'price_unit' => 'nullable|string',
            'quantity_unit' => 'nullable|string',
            'duration' => 'nullable|string',
            'featured' => 'boolean',
            'enable_booking' => 'boolean',
            'provider_id' => 'required|integer',
            'available' => 'boolean',
        ];
    }
}
