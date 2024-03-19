<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'logo',
        'sport_type_id',
    ];

    protected function sportType(): BelongsTo
    {
        return $this->belongsTo(SportType::class);
    }
}
