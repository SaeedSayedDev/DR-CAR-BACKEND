<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'car_license_id',
        'maintenance_type',
        'maintenance_date',
        'parts_changed',
        'changed_parts',
        'report_details',
        'pdf',
    ];

    public function garage()
    {
        return $this->belongsTo(User::class, 'garage_id');
    }

    public function carLicense()
    {
        return $this->belongsTo(CarLicense::class);
    }
}
