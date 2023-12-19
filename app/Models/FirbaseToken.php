<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirbaseToken extends Model
{
    use HasFactory;

    protected $fillable = ['fcsToken', 'user_id', 'user_type'];
}