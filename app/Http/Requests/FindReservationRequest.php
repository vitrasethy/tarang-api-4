<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindReservationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date_format:Y-m-d\TH:i:s.v\Z'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'venue_id' => ['required', 'exists:venues,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
