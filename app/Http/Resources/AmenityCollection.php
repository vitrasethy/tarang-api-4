<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AmenityCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'amenities' => $this->collection,
        ];
    }
}
