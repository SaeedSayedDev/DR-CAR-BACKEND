<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function PHPSTORM_META\type;

class WithdrawWalletRequest extends FormRequest
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
            'amount' => 'required',
            'type' => "required|integer|in:1,2", //1->credit , 2->paypal
            'paypal_email' => 'required_if:type,==,2|email',
            // 'card_number' => 'required_if:type,==,1|min:16|max:16',
            'full_name' => "required_if:type,==,1|string|min:9",
            'account_number' => "required_if:type,==,1",
            'iban' => "required_if:type,==,1|min:28",
            'bank_name' => "required_if:type,==,1"
        ];
    }
}
