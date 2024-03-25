<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmenityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
