<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'size',
        'photo',
        'description',
        'sport_type_id'
    ];

    public function sportType(): BelongsTo
    {
        return $this->belongsTo(SportType::class);
    }
}
