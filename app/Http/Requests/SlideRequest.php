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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'text' => 'required|string',
            'order' => 'required|integer',
            'service_id' => 'required|exists:services,id',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
