<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarageInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'garage_id', 'address', 'short_biography', 'phone_number','phone_verified_at' //private,company
    ];
}