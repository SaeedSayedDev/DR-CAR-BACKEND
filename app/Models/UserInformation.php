<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'address', 'short_biography', 'phone_number', 'phone_verified_at', 'car_id', 'gender'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
