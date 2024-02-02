<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaypalSeuccessRequest extends FormRequest
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
            'paypal_id' => 'required|string',
            'type' => 'required|string|in:booking,user',
            'booking_id' => 'required_if:type,==,booking|integer|exists:booking_services,id,user_id,' . auth()->id()

        ];
    }
}
