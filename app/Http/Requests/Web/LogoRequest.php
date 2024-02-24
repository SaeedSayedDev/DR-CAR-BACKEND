<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class LogoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
