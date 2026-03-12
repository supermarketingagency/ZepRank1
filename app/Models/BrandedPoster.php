<?php

namespace App\Models;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandedPoster extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'branch_id',
        'festival_id',
        'image_path',
        'caption',
        'status',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
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

    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }
}
