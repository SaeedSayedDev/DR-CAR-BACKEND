<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $this->id,
            
            'phone_number' => 'nullable|string',
            'image' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string',
            'short_biography' => 'nullable|string',
        ];
    }
}
