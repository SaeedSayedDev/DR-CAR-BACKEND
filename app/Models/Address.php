<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'latitude', 'longitude', 'description', 'user_id'];

    function garage_data()
    {
        return $this->hasOne(GarageData::class, 'id');
    }
    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
