<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|required|max:255',
            'availability_range' => 'required|numeric',
            'garage_type' => 'required|in:0,1',
            'garage_id' => 'required|exists:users,id',
            'address_id' => 'required|exists:addresses,id',
            'tax_id' => 'required|exists:taxes,id',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
