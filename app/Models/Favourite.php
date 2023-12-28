<?php

namespace App\Models;

use App\Models\Admin\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id', 'user_id'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
