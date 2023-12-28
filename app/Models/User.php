<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

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
        'email_verified_at' // 1=>admin , 2=>customer , 3=>winch , 4=>garage 
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

    public function address()
    {
        return $this->hasOne(Address::class, 'type_id',  'id')->where('type_name', 'user');
    }

    public function userRole()
    {
        return $this->belongsTo(Role::class, 'role_id',  'id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'user');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'provider_id');
    }
}
