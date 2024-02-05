<?php

namespace App\Models\Admin;

use App\Models\Address;
use App\Models\availabilityTime;
use App\Models\BookingService;
use App\Models\Favourite;
use App\Models\GarageData;
use App\Models\ImagesService;
use App\Models\Media;
use App\Models\Options;
use App\Models\Review;
use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'desc', 'price', 'discount_price', 'price_unit',
        'quantity_unit', 'duration', 'featured', 'enable_booking', 'provider_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];
    protected $casts = [
        'price_unit' => 'boolean',
        'featured' => 'boolean',
        'enable_booking' => 'boolean',
    ];


    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
    public function provider()
    {
        return $this->belongsTo(GarageData::class, 'provider_id');
    }
    public function provider_avilabilty_time()
    {
        return $this->belongsTo(availabilityTime::class, 'provider_id', 'provider_id');
    }
    public function avilabilty_range()
    {
        $userLatitude = auth()->user()->address[0]['latitude'];
        $userLongitude = auth()->user()->address[0]['longitude'];

        $availability_range = $this->belongsTo(GarageData::class, 'provider_id')->first()->availability_range;
        return $this->belongsTo(GarageData::class, 'provider_id')->whereHas('address', function ($qr) use ($userLatitude, $userLongitude, $availability_range) {
            $qr->whereBetween('latitude', [$userLatitude - $availability_range, $userLatitude + $availability_range])
                ->whereBetween('longitude', [$userLongitude - $availability_range, $userLongitude + $availability_range])
                ->with('garage_data.services');
        });
    }
    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'service');
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'service_id');
    }


    public function favourite()
    {
        return $this->belongsToMany(Service::class, Favourite::class)->where('user_id', auth()->user() ? auth()->user()->id : 0);
    }

    public function favourite_user()
    {
        return $this->hasOne(Favourite::class)->where('user_id', auth()->user()->id);

        // return $this->name = $this->hasOne(Favourite::class)->where('user_id', auth()->user() ? auth()->user()->id : 0)->first();
    }

    public function options()
    {
        return $this->hasMany(Options::class, 'service_id');
    }
    public function popular()
    {
        return $this->hasMany(BookingService::class, 'service_id');
    }
    public function scopeGetRelashinIndex($query)
    {
        return  $this->whereHas('avilabilty_range')
            ->with('provider.user.userRole', 'provider.address', 'provider.user.media', 'media', 'items', 'favourite')
            ->withSum('review', 'review_value')
            ->withCount('review', 'popular');
    }

    public function scopeWithoutGetRelashinIndex()
    {
        return  $this->with('provider.user.userRole', 'provider.address', 'provider.user.media', 'media', 'items', 'favourite')
            ->withSum('review', 'review_value')
            ->withCount('review', 'popular');
    }
}
