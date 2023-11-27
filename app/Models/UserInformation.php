<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'address', 'short_biography', 'phone_number','image','phone_verified_at'
    ];
}
