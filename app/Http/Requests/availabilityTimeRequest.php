<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class availabilityTimeRequest extends FormRequest
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
            'start_date' => 'required|date_format:H:i',
            'end_date' => 'required|date_format:H:i|after:start_date',
            'day' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'provider_id' => 'required|exists:garage_data,id',

        ];
    }
}
