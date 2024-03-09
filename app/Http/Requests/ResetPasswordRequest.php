<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => 'required|min:8|max:30|string|confirmed',
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required|string|min:6|max:6|exists:otp_users,otp'
            // 'verification_code'=>'required|numeric'
        ];
    }
}
