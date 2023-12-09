<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
        if (request()->isMethod('post')) {
            return [
                'service_id' => 'required|integer|exists:services,id',
                'review_value' => 'required|integer|in:1,2,3,4,5',
                'review' => 'required|string',
            ];
        }
        if (request()->isMethod('put')) {
            return [
                'review_value' => 'required|integer|in:1,2,3,4,5',
                'review' => 'required|string',
            ];
        }
    }
}
