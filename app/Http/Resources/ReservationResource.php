<?php

namespace App\Http\Resources;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Reservation */
class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'attendee' => $this->attendee,
            'date' => $this->date,
            'start_time' => date('h:i A', strtotime($this->start_time)),
            'end_time' => date('h:i A', strtotime($this->end_time)),
            'find_team' => $this->find_team,
            'find_member' => $this->find_member,
            'created_at' => $this->created_at,

            'venue' => new VenueResource($this->whenLoaded('venue')),
            'user' => new UserResource($this->whenLoaded('user')),
            'team' => new TeamResource($this->whenLoaded('team')),
        ];
    }
}
