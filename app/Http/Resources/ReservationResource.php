<?php

namespace App\Http\Resources;

use App\Models\Reservation;
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
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,

            'venue' => new VenueResource($this->whenLoaded('venue')),
            'user' => new VenueResource($this->whenLoaded('user')),
        ];
    }
}
