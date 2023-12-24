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
        $id = auth()->user()->id;

        if(auth()->user()->userRole->id == 3)
        {
            return [
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
    
                'phone_number' => 'nullable|string',
                'address' => 'required|string|min:3',
                'short_biography' => 'nullable|string',
    
                'KM_price' => 'required|string',

                'images' => 'array',
                'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }

        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,

            'phone_number' => 'nullable|string',
            'address' => 'required|string|min:3',
            'short_biography' => 'nullable|string',

            'images' => 'array',
            'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
