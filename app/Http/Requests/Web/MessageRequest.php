<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'users' => 'required|array',
            'users.*' => 'required|exists:users,id',
            'message' => 'required|string',
        ];
    }
}
