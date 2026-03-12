<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateFeedback extends Model
{
    use HasFactory;

    protected $table = 'private_feedbacks';

    protected $fillable = [
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

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
