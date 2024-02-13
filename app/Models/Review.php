<?php

namespace App\Models;

use App\Models\Admin\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'type_id', 'review_value', 'review', 'type'
    ];
    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    function service()
    {
        return $this->belongsTo(Service::class, 'type_id', 'id');
    }
    function winch()
    {
        return $this->belongsTo(User::class, 'type_id', 'id');
    }
}
