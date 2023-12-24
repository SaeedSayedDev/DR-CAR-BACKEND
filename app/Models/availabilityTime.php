<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class availabilityTime extends Model
{
    use HasFactory;
    protected $fillable =[
        'garage_id' ,'day_id','start_data', 'end_data'
    ];
}
