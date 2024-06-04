<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start_date' => 'required|date_format:Y-m-d\TH:i:s.v\Z',
            'end_time' => 'required|date_format:Y-m-d\TH:i:s.v\Z',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
