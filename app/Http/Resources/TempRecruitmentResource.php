<?php

namespace App\Http\Resources;

use App\Models\TempRecruitment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin TempRecruitment */
class TempRecruitmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_accepted' => $this->is_accepted,

            'team' => new TeamResource($this->whenLoaded('team')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
