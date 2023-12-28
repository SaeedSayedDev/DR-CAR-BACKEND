<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class availabilityTime extends Model
{
    use HasFactory;
    protected $fillable =[
        'provider_id' ,'day','start_date', 'end_date'
    ];
}
