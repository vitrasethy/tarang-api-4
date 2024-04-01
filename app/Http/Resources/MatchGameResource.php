<?php

namespace App\Http\Resources;

use App\Models\MatchGame;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MatchGame
 * @property mixed $team1
 * @property mixed $team2
 */
class MatchGameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_accepted' => $this->is_accepted,
            'comment' => $this->comment,

            'reservation' => new ReservationResource($this->whenLoaded('reservation')),
            'team1' => new TeamResource($this->whenLoaded('team', $this->team1)),
            'team2' => new TeamResource($this->whenLoaded('team', $this->team2)),
        ];
    }
}
