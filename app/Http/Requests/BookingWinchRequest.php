<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingWinchRequest extends FormRequest
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
            'booking_service_id' => 'required|integer|exists:booking_services,id',
            'winch_id' => 'required|integer|exists:winch_information,winch_id',
            'round_trip' => 'required|boolean',
            // 'address_id' => 'required|integer|exists:addresses,id,user_id,' . auth()->id(),
        ];
    }
}
