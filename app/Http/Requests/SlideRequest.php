<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'text' => 'required|string',
            'order' => 'required|integer',
            'service_id' => 'required|exists:services,id',
            
            'images' => 'array',
            'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',

        ];
    }
}
