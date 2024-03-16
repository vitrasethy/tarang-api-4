<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VenueRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'size' => ['required', 'integer'],
            'photo' => ['required', 'image'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
