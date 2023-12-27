<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'desc',
        'price',
        'service_id',
        'option_group_id'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function media()
    {
        return $this->hasMany(Media::class, 'type_id')->where('type', 'options');
    }
}
