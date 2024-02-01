<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPaypal extends Model
{
    use HasFactory;
    protected  $fillable = ['metadata'];
}
