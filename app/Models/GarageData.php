<?php

namespace App\Models;

use App\Models\Admin\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarageData extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'availability_range', 'garage_id', 'garage_type', 'tax_id', 'address_id', 'check_servic_id'
    ];
    protected $hidden = [
        'check_servic_id',
    ];

    function user()
    {
        return $this->belongsTo(User::class, 'garage_id');
    }

    function services()
    {
        return $this->hasMany(Service::class, 'provider_id');
    }
    function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    function availabilityTime()
    {
        return $this->hasMany(availabilityTime::class, 'provider_id', 'id');
    }

    function taxe()
    {
        return $this->belongsTo(Taxe::class, 'tax_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'garage_data');
    }
}
