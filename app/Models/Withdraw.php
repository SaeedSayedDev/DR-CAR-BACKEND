<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'amount', 'status' ,'type','paypal_email','full_name' ,'account_number','iban','bank_name' //1->credit , 2->paypal
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
