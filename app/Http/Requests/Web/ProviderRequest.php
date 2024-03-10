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
        $rules = [
            'name' => 'required|string|max:255',
            'availability_range' => 'required|numeric',
            'garage_id' => 'required|exists:users,id',
            'address_id' => 'required',
            'tax_id' => 'required|exists:taxes,id',
        ];
        
        if ($this->isMethod('POST')) {
            $rules['checkServicePrice'] = 'required|numeric';
        }
        
        return $rules;        
    }
}
