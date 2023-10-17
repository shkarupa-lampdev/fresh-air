<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ChartDailyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|\Illuminate\Contracts\Validation\ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'timeStart' => [
                'required',
                'date',
            ],
            'timeEnd' => [
                'required',
                'date',
                'before_or_equal:now',
                function ($attribute, $value, $fail) {
                    $min = Carbon::parse($this->input('timeStart'));
                    $max = Carbon::parse($this->input('timeEnd'));

                    if ($max->diffInHours($min) <= 48) {
                        $fail('Різниця між часом початку та кінця має буті не менше ніж 48 години.');
                    }
                },
            ],
        ];
    }
}
