<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user_id =  auth()->user()->id;
        if (auth()->user()->userRole->id == 2) {
            $id = auth()->user()->user_information->id;
            $phoneValidation = 'nullable|string|unique:winch_information,phone_number|unique:garage_information,phone_number|
            unique:user_information,phone_number,' . $id;
        }
        if (auth()->user()->userRole->id == 3) {
            $id = auth()->user()->winch_information->id;
            $phoneValidation = 'nullable|string|unique:user_information,phone_number|unique:garage_information,phone_number|
            unique:winch_information,phone_number,' . $id;
        }
        if (auth()->user()->userRole->id == 4) {
            $id = auth()->user()->garage_information->id;
            $phoneValidation = 'nullable|string|unique:winch_information,phone_number|unique:user_information,phone_number|
            unique:garage_information,phone_number,' . $id;
        }

        if (auth()->user()->userRole->id == 3) {
            return [
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user_id,

                'phone_number' => $phoneValidation,
                'address' => 'required|string|min:3',
                'short_biography' => 'nullable|string',

                'KM_price' => 'required|string',
                'availability_range' => 'required',
                'images' => 'array',
                'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }

        if (auth()->user()->userRole->id == 4) {
            return [
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user_id,
                'phone_number' => $phoneValidation,
                'address' => 'required|string|min:3',
                'short_biography' => 'nullable|string',
                'gender' => 'required|integer|in:1,2', //1 -> female, 2 -> male
                'birth_date' => 'required|string',
                'images' => 'array',
                'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }

        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user_id,
            'phone_number' => $phoneValidation,
            'address' => 'required|string|min:3',
            'short_biography' => 'nullable|string',
            'images' => 'array',
            'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
