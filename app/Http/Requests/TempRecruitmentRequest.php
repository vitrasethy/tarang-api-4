<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TempRecruitmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_accepted' => ['boolean'],
            'team_id' => ['required', 'exists:teams,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
