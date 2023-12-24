<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinchInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'winch_id', 'address', 'short_biography', 'phone_number','phone_verified_at','KM_price'
    ];
}
