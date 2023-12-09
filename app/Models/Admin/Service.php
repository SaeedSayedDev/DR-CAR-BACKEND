<?php

namespace App\Models\Admin;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'image', 'name', 'desc', 'price', 'discount_price', 'price_unit',
        'quantity_unit', 'duration', 'featured', 'enable_booking', 'rating','provider_id'
    ];
    protected $translatedAttributes = [
        'name', 'desc',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'translations',
    ];
    protected $casts = [
        'price_unit' => 'boolean',
        'featured' => 'boolean',
        'enable_booking' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(ServiceTranslation::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
