<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'amount', 'status' ,'type','paypal_email','card_number' //1->credit , 2->paypal
    ];



}
