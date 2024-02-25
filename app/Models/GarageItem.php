<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarageItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'garage_id', 'item_id'
    ];
}
