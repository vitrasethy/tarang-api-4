<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'logo' => ['nullable', 'image'],
            'sport_type_id' => 'required|exists:sport_types,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
