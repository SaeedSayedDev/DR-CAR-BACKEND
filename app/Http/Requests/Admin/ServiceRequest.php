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
            'name' => 'string|required|max:255',
            'desc' => 'string|nullable',
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
            'images' => 'array',
            'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',

        ];
    }
}
