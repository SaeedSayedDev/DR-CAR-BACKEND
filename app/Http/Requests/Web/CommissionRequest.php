<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CommissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'commission' => 'required|numeric',
            'type' => 'required|boolean', // 0 -> fixed, 1 -> percent
            'commission_from' => 'required|boolean', // 0 -> user, 1 -> garage
        ];
    }
}
