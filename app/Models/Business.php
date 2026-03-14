<?php

namespace App\Models;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_user_id',
        'reseller_id',
        'name',
        'slug',
        'category',
        'city',
        'state',
        'phone',
        'website',
        'logo_path',
        'cover_image_path',
        'status',
        'onboarding_step',
        'onboarding_completed',
        'ai_provider',
        'ai_model',
        'ai_api_key_encrypted',
    ];

    protected $casts = [
        'onboarding_completed' => 'boolean',
        'ai_api_key_encrypted' => 'encrypted',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new BusinessScope());
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function googleProfileConnection()
    {
        return $this->hasOne(GoogleProfileConnection::class);
    }
}
