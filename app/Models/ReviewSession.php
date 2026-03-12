<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewSession extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
