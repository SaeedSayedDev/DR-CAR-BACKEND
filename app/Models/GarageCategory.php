<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarageCategory extends Model
{
    use HasFactory;
    protected $table = 'garage_categories';

    protected $fillable = [
        'garage_id', 'category_id'
    ];
}
