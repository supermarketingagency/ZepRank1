<?php

namespace App\Models;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'branch_id',
        'session_token',
        'touchpoint_type',
        'star_rating',
        'route',
        'mcq_completed',
        'ai_draft_selected',
        'copy_confirmed',
        'google_redirect_completed',
        'ai_provider_used',
        'ai_model_used',
        'device_type',
        'ip_address',
        'user_agent',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new BusinessScope());
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
