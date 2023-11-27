<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'image' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'string|required|exists:categories,id',
        ];
    }
}
