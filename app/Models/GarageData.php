<?php

namespace App\Models;

use App\Models\Admin\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarageData extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'availability_range', 'garage_id', 'garage_type', 'tax_id'
    ];

    function user()
    {
        return $this->belongsTo(User::class, 'garage_id');
    }

    function services()
    {
        return $this->hasMany(Service::class, 'provider_id');
    }
}
