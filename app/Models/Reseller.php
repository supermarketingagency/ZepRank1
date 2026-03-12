<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reseller extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'custom_domain',
        'brand_name',
        'logo_path',
        'primary_color',
        'secondary_color',
        'status',
        'wholesale_plan',
        'wholesale_monthly_fee',
        'feature_overrides',
        'custom_css',
        'smtp_config_encrypted',
    ];

    protected $casts = [
        'feature_overrides' => 'json',
        'smtp_config_encrypted' => 'encrypted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
