<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchGameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_accepted' => ['sometimes', 'boolean'],
            'team1_id' => ['required', 'exists:teams,id'],
            'team2_id' => ['sometimes', 'exists:teams,id'],
            'reservation_id' => 'required|exists:reservations,id',
            'team2_phone' => 'sometimes|string|digits:13',
            'comment' => 'nullable|string'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
