<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'display_duration',
        'amount',
        'text',
        'gender',
        'coupon',
        'car_type',
        'car_start_date',
        'car_end_date',
        'status',
        'display',
        'display_start_date',
        'display_end_date',
        'rejection_reason',
    ];

    public function garage()
    {
        return $this->belongsTo(User::class, 'garage_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'ad');
    }
}
