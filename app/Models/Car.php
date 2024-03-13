<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'car');
    }

    public function ads()
    {
        return $this->belongsToMany(BookingAd::class, 'booking_ad_car', 'car_id', 'booking_ad_id');
    }
}
