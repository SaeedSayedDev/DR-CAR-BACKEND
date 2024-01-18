<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->route('user'),
            'password' => 'required|string|min:8',
            'role_id' => 'required|in:2,3,4',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'short_biography' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
