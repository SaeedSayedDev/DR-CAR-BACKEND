<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'owner_en',
        'owner_ar',
        'nationality_en',
        'nationality_ar',

        'number_of_passengers',
        'model',
        'origin_en',
        'origin_ar',
        'color',
        'class',
        'type_en',
        'type_ar',
        'gross_weight',
        'empty_weight',
        'engine_number',
        'chassis_number',
        
        'traffic_code_number',
        'traffic_plate_number',
        'plate_class',
        'place_of_issue',
        'expiry_date',
        'registration_date',
        'insurance_expiry',
        'policy_number',
        'insured_company',
        'insurance_type',
        'mortgaged_by',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'car_license');
    }
}
