<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateBookingWinchRequest extends FormRequest
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
            'order_status_id' => 'required|exists:status_orders,id',
            'image_front' => 'image|required_if:order_status_id,==,4',
            'image_back' => 'image|required_if:order_status_id,==,4',
            'image_right_side' => 'image|required_if:order_status_id,==,4',
            'image_left_side' => 'image|required_if:order_status_id,==,4',
        ];
    }
}
