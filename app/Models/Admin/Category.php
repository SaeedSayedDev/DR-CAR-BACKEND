<?php

namespace App\Models\Admin;

use App\Models\Media;
use Astrotomic\Translatable\Translatable;
// use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Translatable;
    // use HasTranslations;


    protected $fillable = [
        'name', 'desc', 'public',
    ];
    public $translatedAttributes = [
        'name', 'desc'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'translations'
    ];

    // public function translations()
    // {
    //     return $this->hasMany(CategoryTranslation::class);
    // }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'category');
    }
}
