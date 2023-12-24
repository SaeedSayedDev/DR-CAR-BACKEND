<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => "nullable|unique:user_information,phone_number|unique:winch_information,phone_number|unique:garage_information,phone_number|min:8|max:15",
            'password' => 'required|confirmed|string|min:8|max:20', // password_confirmation
            'role_id' => 'required|integer|exists:roles,id',
            'garage_type' => 'string|required_if:role_id,==,4|in:private,company'
        ];
    }
}
