<?php

namespace App\Models;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleProfileConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'branch_id',
        'google_account_id',
        'google_location_id',
        'access_token',
        'refresh_token',
        'expires_at',
        'profile_data',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'profile_data' => 'array',
        'access_token' => 'encrypted',
        'refresh_token' => 'encrypted',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new BusinessScope());
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
