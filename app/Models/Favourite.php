<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id', 'user_id'
    ];

    public function service()
    {
        return $this->belongsTo(User::class, 'service_id',  'id');
    }
}
