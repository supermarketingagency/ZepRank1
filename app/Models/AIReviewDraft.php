<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\BusinessScope;

class AIReviewDraft extends Model
{
    protected $table = 'ai_review_drafts';

    protected $fillable = [
        'business_id',
        'review_session_id',
        'draft_number',
        'content',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new BusinessScope());
    }

    public function session()
    {
        return $this->belongsTo(ReviewSession::class, 'review_session_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
