<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchGameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_accepted' => ['boolean'],
            'team1_id' => ['required', 'exists:teams,id'],
            'team2_id' => ['required', 'exists:team,id'],
            'reservation_id' => 'required|exists:reservations,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
