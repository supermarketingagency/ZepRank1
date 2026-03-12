<?php

namespace App\Models;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateFeedback extends Model
{
    use HasFactory;

    protected $table = 'private_feedbacks';

    protected $fillable = [
        'business_id',
        'branch_id',
        'review_session_id',
        'encrypted_content',
        'star_rating',
        'sentiment_score',
        'sentiment_label',
        'status',
        'assignee_id',
        'is_read',
        'resolved_at',
    ];

    protected $casts = [
        'encrypted_content' => 'encrypted',
        'resolved_at' => 'datetime',
        'is_read' => 'boolean',
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
