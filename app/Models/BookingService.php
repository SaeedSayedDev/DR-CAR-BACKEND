<?php

namespace App\Models;

use App\Models\Admin\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'service_id',
        'address_id',
        'hint',
        'coupon',
        // 'as_soon_as',
        'come_to_address_date', //required if as_soon_as false
        'booking_at',
        'quantity', // required if unit price in service is fixed
        'order_status_id',
        // 'payment_id',
        'taxes',
        // 'start_at',
        // 'ends_at',
        'cancel',
        'payment_stataus',
        'payment_amount',
        'payment_type',
        'payment_id',
        'delivery_car'

    ];

    public function serviceProvider()
    {
        return $this->belongsTo(Service::class, 'service_id')->where('provider_id', auth()->user()->garage_data->id);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function booking_winch()
    {
        return $this->hasOne(BookingWinch::class, 'booking_service_id')->where('order_status_id', '>', 1)->where('order_status_id', '<', 6)
            ->where('cancel', false)
            ->where('payment_stataus', 'unpaid');
    }
}