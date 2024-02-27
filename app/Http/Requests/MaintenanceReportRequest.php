<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceReportRequest extends FormRequest
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
            
            'pdf' => 'nullable|file|mimes:pdf',
            'images' => 'nullable|array|size:2',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
