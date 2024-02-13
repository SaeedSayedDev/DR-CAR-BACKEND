<?php

namespace App\Models;

use App\Models\Admin\StatusOrder;
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

    public function bookingService()
    {
        return $this->belongsTo(BookingService::class, 'booking_service_id');
    }


    public function address()
    {
        return $this->belongsTo(Address::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function winch()
    {
        return $this->belongsTo(User::class, 'winch_id');
    }
    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'winch_receive');
    }
    public function status_order()
    {
        return $this->belongsTo(StatusOrder::class, 'order_status_id');
    }
}
