<?php

namespace App\Models\Admin;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'name', 'desc', 'image'
    ];
    public $translatedAttributes = [
        'name', 'desc'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
