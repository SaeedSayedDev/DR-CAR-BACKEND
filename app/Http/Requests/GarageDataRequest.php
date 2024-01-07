<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GarageDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'availability_range' => 'required|integer|min:1',
            'garage_type' => 'required|integer|in:0,1',
            'tax_id' => 'required|exists:taxes,id',
            'address_id' => 'required|exists:addresses,id,user_id,' . auth()->id(),
        ];
    }
}
