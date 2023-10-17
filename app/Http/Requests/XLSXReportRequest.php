<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class XLSXReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|\Illuminate\Contracts\Validation\ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'dateFrom' => 'required|date_format:Y-m-d\TH:i',
            'dateTo' => [
                'required',
                'date_format:Y-m-d\TH:i',
                function ($attribute, $value, $fail) {
                    $min = Carbon::parse($this->input('dateFrom'));
                    $max = Carbon::parse($this->input('dateTo'));

                    if ($max->diffInMinutes($min) < 20) {
                        $fail('Різниця між часом початку та кінця має бути не менше ніж 20 хвилин.');
                    }
                    if ($max->diffInHours($min) > 24) {
                        $fail('Різниця між часом початку та кінця має бути не більше ніж 24 години.');
                    }
                },
            ],
        ];
    }
}
