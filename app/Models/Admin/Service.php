<?php

namespace App\Models\Admin;

use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'image', 'name', 'desc', 'price', 'discount_price', 'price_unit',
        'quantity_unit', 'duration', 'featured', 'enable_booking', 'rating', 'provider_id'
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
        return $this->belongsTo(User::class, 'provider_id');
    }
}
