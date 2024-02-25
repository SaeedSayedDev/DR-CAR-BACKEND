<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarageCars extends Model
{
    use HasFactory;
    protected $fillable = [
        'garage_id', 'car_id'
    ];
}
