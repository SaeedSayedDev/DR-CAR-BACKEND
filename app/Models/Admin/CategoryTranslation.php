<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'desc', 'locale',
    ];
    protected $hidden = [
        'locale','created_at','updated_at'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
