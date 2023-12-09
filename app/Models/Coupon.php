<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date', 'end_date', 'coupon', 'provider_id', 'coupon_unit' /* (fixed =>0 , percentage=>1) */, 'coupon_price'
    ];
}
