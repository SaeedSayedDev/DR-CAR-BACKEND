<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class chargeWalletRequest extends FormRequest
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
            'card_name' => 'required_if:payment_type,==,2|string|min:9|max:50',
            'card_number' => 'required_if:payment_type,==,2|string|min:16|max:16',
            'cvc' => 'required_if:payment_type,==,2|string|min:3|max:4',
            'exp_month' => 'required_if:payment_type,==,2|string|date_format:m',
            'exp_year' => "required_if:payment_type,==,2|string|date_format:Y",
            'payment_type' => 'required|integer|exists:payment_methods,payment_type',
            'amount'=>'required'
        ];
    }
}
