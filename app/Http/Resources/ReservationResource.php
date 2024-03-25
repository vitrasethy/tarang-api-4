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
            'date' => Carbon::parse($this->date)->toFormattedDayDateString(),
            'start_time' => date('h:i A', strtotime($this->start_time)),
            'end_time' => date('h:i A', strtotime($this->end_time)),
            'find_team' => $this->find_team,
            'find_member' => $this->find_member,

            'venue' => new VenueResource($this->whenLoaded('venue')),
            'user' => new VenueResource($this->whenLoaded('user')),
        ];
    }
}
