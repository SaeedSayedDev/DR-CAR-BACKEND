<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'service_id', 'review_value', 'review'
    ];
    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
