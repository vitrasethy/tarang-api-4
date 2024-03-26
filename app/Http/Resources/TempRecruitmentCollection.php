<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TempRecruitmentCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'temp_recruitments' => $this->collection,
        ];
    }
}
