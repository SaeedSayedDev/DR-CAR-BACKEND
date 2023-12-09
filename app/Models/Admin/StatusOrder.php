<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class StatusOrder extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'name',
    ];
    protected $translatedAttributes = [
        'name',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'translations',
    ];
}
