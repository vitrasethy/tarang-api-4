<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VenueRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'size' => ['required', 'integer'],
            'photo' => ['nullable', 'url:http,https'],
            'description' => ['nullable', 'string'],
            'sport_type_id' => 'required|exists:sport_types,id',
            'amenity_id.*' => 'required|exists:amenities,id'
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
