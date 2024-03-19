<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'need_team_against',
        'need_player',
        'team_id',
        'reservation_id',
    ];

    protected function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    protected function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
