<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Admin\Category;
use App\Models\Admin\Item;
use App\Models\Admin\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'role_id',
        'email_verified_at',
        'ban' // 1=>admin , 2=>customer , 3=>winch , 4=>garage 
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    public function user_information()
    {
        return $this->hasOne(UserInformation::class, 'user_id',  'id');
    }
    public function winch_information()
    {
        return $this->hasOne(WinchInformation::class, 'winch_id',  'id');
    }
    public function garage_information()
    {
        return $this->hasOne(GarageInformation::class, 'garage_id',  'id');
    }

    public function garage_data()
    {
        return $this->hasOne(GarageData::class, 'garage_id',  'id');
    }

    public function otpUser()
    {
        return $this->hasOne(OtpUser::class, 'user_id',  'id')->where('type_user', 'user');
    }

    public function otpAdmin()
    {
        return $this->hasOne(OtpUser::class, 'user_id',  'id')->where('type_user', 'admin');
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'user_id',  'id');
    }

    public function addressUser()
    {
        return $this->hasOne(Address::class, 'user_id',  'id');
    }

    public function userRole()
    {
        return $this->belongsTo(Role::class, 'role_id',  'id');
    }

    public function media()
    {
        return $this->hasOne(Media::class, 'type_id')->where('type', 'user');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'provider_id');
    }

    public function info()
    {
        return match ($this->role_id) {
            2 => $this->user_information,
            3 => $this->winch_information,
            4 => $this->garage_information,
            default => null
        };
    }

    public function loadUserInfo()
    {
        $userInfo = match ($this->role_id) {
            2 => $this->user_information,
            3 => $this->winch_information,
            4 => $this->garage_information,
            default => null,
        };

        $this->info = $userInfo;
        unset($this->user_information, $this->winch_information, $this->garage_information);

        return $this;
    }

    public function avilabilty_range()
    {
        $userLatitude = auth()->user()->address[0]['latitude'];
        $userLongitude = auth()->user()->address[0]['longitude'];
        $availability_range = $this->belongsTo(WinchInformation::class, 'winch_id')->first()->availability_range;
        $availability_range = 500;
        return $this->hasOne(Address::class, 'user_id')
            ->whereHas('user', function ($q) {
                $q->where('role_id', 3);
            })
            ->whereBetween('latitude', [$userLatitude - $availability_range, $userLatitude + $availability_range])
            ->whereBetween('longitude', [$userLongitude - $availability_range, $userLongitude + $availability_range]);
    }

    public function carLicense()
    {
        return $this->hasOne(CarLicense::class);
    }

    public function bookingAds()
    {
        return $this->hasMany(BookingAd::class, 'garage_id');
    }

    public function garage_support_cars()
    {
        return $this->belongsToMany(Car::class, GarageCars::class, 'garage_id', 'car_id');
    }
    public function garage_support_category()
    {
        return $this->belongsToMany(Category::class, GarageCategory::class, 'garage_id', 'category_id');
    }

    public function carReports()
    {
        return $this->hasMany(CarReport::class, 'garage_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }



    public function bookingsWinch()
    {
        return $this->hasMany(BookingWinch::class, 'winch_id');
    }


    public function scopeWithBookingWinch($query)
    {
        return $query->join('booking_winches', 'booking_winches.winch_id', '=', 'users.id')
            ->select('booking_winches.*', 'users.*')
            ->with(['bookingsWinch.bookingService']);
        }
    public function scopeWithBookingService($query)

    {
        return $query->join('booking_services', 'booking_services.id', '=', 'booking_winches.booking_service_id')
            ->select('booking_services.*', 'booking_winches.*');
    }
}
