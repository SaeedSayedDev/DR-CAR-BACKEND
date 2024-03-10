<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarReportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'maintenance_type' => 'required|string',
            'maintenance_date' => 'required|date',
            'parts_changed' => 'required|boolean',
            'changed_parts' => 'required_if:parts_changed,true|string',
            'report_details' => 'nullable|string',
            
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
