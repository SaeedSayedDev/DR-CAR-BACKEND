<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'display_duration',
        'amount',
        'text',
        'gender',
        'coupon',
        'car_type',
        'car_start_date',
        'car_end_date',
        'status',
        'display',
        'display_start_date',
        'display_end_date',
        'rejection_reason',
    ];

    public function garage()
    {
        return $this->belongsTo(User::class, 'garage_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'ad');
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'booking_ad_car', 'booking_ad_id', 'car_id');
    }

    public static function expire()
    {
        static::where('display_end_date', '<', now())->update(['display' => false]);
    }

    public static function adsForUser($user)
    {
        static::expire();

        return static::where('display', true)
            ->where('car_start_date', '<=', $user->carLicense->model)
            ->where('car_end_date', '>=', $user->carLicense->model)
            ->whereIn('gender', [$user->user_information->gender, 2])
            ->whereHas('cars', function ($query) use ($user) {
                $query->where('car_id', $user->user_information->car_id);
            })->get();
    }

    public static function adsForGuest()
    {
        static::expire();

        return static::where('display', true)->get();
    }
}
