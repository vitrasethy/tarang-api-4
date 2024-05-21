<?php

namespace App\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Team */
class TeamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo,

            'sportType' => new SportTypeResource($this->whenLoaded('sportType')),
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
