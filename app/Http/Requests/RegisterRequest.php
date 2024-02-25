<?php

namespace App\Http\Requests;

use App\Models\Admin\Item;
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

        // $item = Item::whereHas('category', function ($query) {
        //     $query->where('public', true);
        // })
        //     ->whereIn('id', request()->subCategories)->get();

        if (request()->role_id == 4) {
            return [
                'full_name' => 'required|string|min:3|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'phone_number' => "nullable|unique:user_information,phone_number|unique:winch_information,phone_number|unique:garage_information,phone_number|min:8|max:15",
                'password' => 'required|confirmed|string|min:8|max:20', // password_confirmation
                'role_id' => 'required|integer|exists:roles,id|in:3,4',
                'subCategories' => 'required|array|min:1',
                'subCategories.*' => 'exists:items,id',
                'cars' => 'required|array|min:1|max:2', // Change 5 to your desired limit
                'cars.*' => 'exists:cars,id',

                // 'garage_type' => 'string|required_if:role_id,==,4|in:private,company'

            ];
        }
        return [
            'full_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => "nullable|unique:user_information,phone_number|unique:winch_information,phone_number|unique:garage_information,phone_number|min:8|max:15",
            'password' => 'required|confirmed|string|min:8|max:20', // password_confirmation
            'role_id' => 'required|integer|exists:roles,id|in:3,4',
            // 'garage_type' => 'string|required_if:role_id,==,4|in:private,company'

        ];
    }
}
