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
        'payment_type',
        'payment_id',
        'delivery_car'

    ];

    public function serviceProvider()
    {
        return $this->belongsTo(Service::class, 'service_id')->where('provider_id', auth()->user()->id);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}

