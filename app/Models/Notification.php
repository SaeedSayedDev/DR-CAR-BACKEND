<?php

namespace App\Models;

use App\Models\Admin\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_id', 'creator_name', 'user_id', 'text_en', 'text_ar', 'api', 'notification_type_en', 'notification_type_ar', 'read'
    ];

    function booking_service()
    {
        return $this->belongsTo(BookingService::class, 'type_id')
            ->where('api', 'LIKE', '%api/booking/show%');
    }

    function booking_winch()
    {
        return $this->belongsTo(BookingWinch::class, 'type_id')
            ->where('api', 'LIKE', '%api/booking/winch/show%');
    }
}
