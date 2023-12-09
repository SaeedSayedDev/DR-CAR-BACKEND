<?php

namespace App\Http\Requests\Admin;

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
            'image' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'name.en' => 'string|required|max:255',
            'name.ar' => 'string|required|max:255',
            'desc.en' => 'string|nullable',
            'desc.ar' => 'string|nullable',
            'price' => 'required|numeric',
            'discount_price' => 'numeric',
            'price_unit' => 'required|boolean',
            'quantity_unit' => 'integer',
            'duration' => 'nullable|date_format:H:i:s',
            'featured' => 'boolean',
            'enable_booking' => 'boolean',
            'rating' => 'required|integer|between:1,5',
            'items' => 'array',
            'items.*' => 'exists:items,id',
        ];
    }
}
