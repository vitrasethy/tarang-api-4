<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string'],
            'attendee' => ['nullable', 'integer'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'venue_id' => ['required', 'exists:venues,id'],
            'find_team' => ['required', 'boolean'],
            'find_member' => ['required', 'boolean'],
            'team_id' => ['nullable', 'exists:teams,id'],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
