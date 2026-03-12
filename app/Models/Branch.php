<?php

namespace App\Models;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'business_id',
        'name',
        'slug',
        'address',
        'google_review_url',
        'negative_review_threshold',
        'review_link_active',
        'ai_provider_override',
        'ai_model_override',
        'ai_api_key_encrypted',
    ];

    protected $casts = [
        'review_link_active' => 'boolean',
        'ai_api_key_encrypted' => 'encrypted',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new BusinessScope());
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function reviewSessions()
    {
        return $this->hasMany(ReviewSession::class);
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }
}
