<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'service_id',
        'address',
        'hint',
        'coupon',
        'as_soon_as',
        'come_to_address_date', //required if as_soon_as false
        'quantity', // required if unit price in service is fixed
        'order_status_id',
        // 'payment_id',
        'taxes',
        // 'start_at',
        // 'ends_at',
        'cancel',
        'payment_stataus',
        'payment_amount',
    
    ];
}
