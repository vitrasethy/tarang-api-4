<?php

namespace App\Http\Resources;

use App\Models\MatchGame;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MatchGame
 */
class MatchGameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "is_accepted" => $this->is_accepted,
            "comment" => $this->comment,

            "reservation" => new ReservationResource($this->whenLoaded("reservation")),
            "user1" => new UserResource($this->whenLoaded("users")),
            "user2" => new UserResource($this->whenLoaded("users")),
        ];
    }
}
