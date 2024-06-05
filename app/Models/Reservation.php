<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'phone', 'attendee', 'date', 'start_time', 'end_time',
        'venue_id', 'user_id', 'find_team', 'find_member',
        'team_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function matchGame(): HasOne
    {
        return $this->hasOne(MatchGame::class);
    }

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }


}
