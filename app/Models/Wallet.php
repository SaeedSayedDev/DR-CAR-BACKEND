<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'total_balance', 'awating_transfer', 'total_balance_doller', 'awating_transfer_doller','name'
    ];
}
