<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingWinch extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'winch_id',
        'address_id',
        'booking_service_id',

        'order_status_id',
        'cancel',

        'payment_stataus',
        'payment_amount',
        'payment_type',
        'payment_id',
    
    ];
}
