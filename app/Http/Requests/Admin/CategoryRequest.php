<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name.en' => 'string|required|max:255',
            'name.ar' => 'string|required|max:255',
            'desc.en' => 'string|nullable',
            'desc.ar' => 'string|nullable',
            
            'images' => 'array',
            'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
