<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'industry_category',
        'question_text',
        'flow_type',
        'order',
        'is_active',
    ];

    public function options()
    {
        return $this->hasMany(McqOption::class);
    }
}
