<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_id', 'creator_name', 'user_id', 'text_en', 'text_ar', 'api', 'notification_type_en', 'notification_type_ar'
    ];
}
