<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchGameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_accepted' => ['sometimes', 'boolean'],
            'reservation_id' => 'required|exists:reservations,id',
            'comment' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
