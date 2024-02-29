<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'car_license_id',
        'booking_service_id',
        
        'maintenance_type',
        'maintenance_date',
        'parts_changed',
        'changed_parts',
        'report_details',
        'pdf',
    ];

    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'service_report');
    }
    
    public function garage()
    {
        return $this->belongsTo(User::class, 'garage_id');
    }

    public function carLicense()
    {
        return $this->belongsTo(CarLicense::class);
    }

    public function bookingService()
    {
        return $this->belongsTo(BookingService::class);
    }
}
