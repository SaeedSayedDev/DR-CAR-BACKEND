<?php

namespace App\Models\Admin;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_type', 'name', 'logo', 'enabled', 'default',
    ];
    
    public function media()
    {
        return $this->hasOne(Media::class, 'type_id')->where('type', 'payment_method');
    }
}
