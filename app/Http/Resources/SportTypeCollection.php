<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SportTypeCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'sport_types' => $this->collection,
        ];
    }
}
