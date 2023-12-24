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
        'address',
        'hint',

        'order_status_id',
        'taxes',
        'cancel',

        'payment_stataus',
        'payment_amount',
        'payment_type',
        'payment_id',
    
    ];
}
