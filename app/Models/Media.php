<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'image', 'type', 'type_id'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function imageName()
    {
        return basename(parse_url($this->image, PHP_URL_PATH));
    }

    static function appLogo()
    {
        return self::where('type', 'logo')->first();
    }
}
