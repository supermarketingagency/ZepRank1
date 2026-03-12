<?php

namespace App\Models;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'branch_id',
        'reviewer_name',
        'reviewer_photo_url',
        'rating',
        'comment',
        'reply_suggestion',
        'actual_reply',
        'replied_at',
        'google_review_id',
        'review_date',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'review_date' => 'datetime',
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
