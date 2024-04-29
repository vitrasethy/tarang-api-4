<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('teams')->ignore($this->route('team'))],
            'logo' => ['nullable', 'url:http,https'],
            'sport_type_id' => 'required|exists:sport_types,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
