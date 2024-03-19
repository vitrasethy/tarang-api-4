<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'need_team_against' => ['required', 'boolean'],
            'need_player' => ['required', 'boolean'],
            'reservation_id' => ['required', 'exists:reservations,id'],
            'team_id' => ['required', 'exists:teams,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
