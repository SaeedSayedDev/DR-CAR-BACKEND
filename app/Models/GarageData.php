<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarageData extends Model
{
    use HasFactory;
    protected $fillable = [
        'availability_range', 'garage_id', 'garage_type', 'tax_id'
    ];

    function user()
    {
        return $this->belongsTo(User::class, 'garage_id');
    }
}