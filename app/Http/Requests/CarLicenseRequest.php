<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarLicenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = auth()->user()->carLicense?->id;

        return [
            'owner_en' => 'required|string|max:255',
            'owner_ar' => 'nullable|string|max:255',
            'nationality_en' => 'required|string|max:255',
            'nationality_ar' => 'nullable|string|max:255',

            'number_of_passengers' => 'required|integer',
            'model' => 'required|integer',
            'origin_en' => 'required|string',
            'origin_ar' => 'nullable|string',
            'color' => 'required|string',
            'class' => 'required|string',
            'type_en' => 'required|string',
            'type_ar' => 'nullable|string',
            'gross_weight' => 'required|string',
            'empty_weight' => 'required|string',
            'engine_number' => 'required|string',
            'chassis_number' => 'required|string',

            'traffic_code_number' => 'required|string|unique:car_licenses,traffic_code_number,' . $id,
            'traffic_plate_number' => 'required|string|unique:car_licenses,traffic_plate_number,' . $id,
            'plate_class' => 'required|string',
            'place_of_issue' => 'required|string',
            'expiry_date' => 'required|date',
            'registration_date' => 'required|date',
            'insurance_expiry' => 'required|date',
            'policy_number' => 'required|string',
            'insured_company' => 'required|string',
            'insurance_type' => 'required|string',
            'mortgaged_by' => 'nullable|string',
            'notes' => 'nullable|string',

            'images' => 'required|array|size:2',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
