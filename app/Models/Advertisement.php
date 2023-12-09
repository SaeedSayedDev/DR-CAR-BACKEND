<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    protected $fillable = [
        'image', 'duration_by_day', 'promotion_type', 'company_id',
        'external_link', 'start_date', 'end_date', 'admin_approve', 'refund', 'invoice_id', 'confirm', 'amount', 'admin_refund', 'desc'
    ];

    public function company()
    {
        return $this->belongsTo(CompanyInformation::class, 'company_id',  'id');
    }
    public function scopeCheckAds($query, $company_information_id)
    {
        return $query->where('company_id', $company_information_id)->where('admin_approve', false)->where('refund', false);
    }
}
