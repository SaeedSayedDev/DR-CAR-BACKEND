<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'total_balance', 'awating_transfer', 'name', 'total_earning'
    ];
    public function total_transaction()
    {
        return $this->hasMany(AccountStatement::class, 'wallet_id', 'id');
    }
  
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
