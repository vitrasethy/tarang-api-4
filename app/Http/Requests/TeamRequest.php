<?php

namespace App\Http\Requests;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'logo' => ['nullable', 'url:http,https'],
            'sport_type_id' => 'required|exists:sport_types,id'
        ];
    }

    public function authorize(): bool
    {
        $teams = Team::with('users')->whereHas('users', function (Builder $query) {
            $query->where('users.id', auth()->id());
        })->count();

        return $teams <= 2;
    }
}
