<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string'],
            'attendee' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date'],
            'user_id' => 'required|exists:users,id',
            'venue_id' => 'required|exists:venues,id'
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
