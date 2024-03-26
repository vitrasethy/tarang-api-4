<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MatchGameCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'match_games' => $this->collection,
        ];
    }
}
