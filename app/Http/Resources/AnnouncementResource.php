<?php

namespace App\Http\Resources;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Announcement */
class AnnouncementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'need_team_against' => $this->need_team_against,
            'need_player' => $this->need_player,

            'team' => new TeamResource($this->whenLoaded('team')),
            'reservation' => new ReservationResource($this->whenLoaded('reservation')),
        ];
    }
}
