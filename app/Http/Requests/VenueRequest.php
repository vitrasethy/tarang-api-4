<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VenueRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:venues,name'],
            'size' => ['required', 'integer'],
            'photo' => ['required', 'url:http,https'],
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
