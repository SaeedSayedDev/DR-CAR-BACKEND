<?php

namespace App\Models\Admin;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'name', 'desc', 'image', 'category_id'
    ];
    protected $translatedAttributes = [
        'name', 'desc'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'translations', 'category_id', 'pivot',
    ];

    public function translations()
    {
        return $this->hasMany(ItemTranslation::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
