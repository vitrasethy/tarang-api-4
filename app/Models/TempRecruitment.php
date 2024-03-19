<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempRecruitment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'is_accepted',
        'team_id',
        'user_id',
    ];

    protected function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
