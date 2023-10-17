<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class FirstTypeReportRequest extends FormRequest
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
            'period' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $dateTo = Carbon::parse($this->input('dateFrom'));
                    $dateFrom = Carbon::parse($this->input('dateFrom'));
                    switch ($this->input('period')) {
                        case '20m':
                            $dateTo->addMinutes(20);
                            break;
                        case 'hour':
                            $dateTo->addHour();
                            break;
                        case 'day':
                            $dateTo->addDay();
                            break;
                        case 'week':
                            $dateTo->addWeek();
                            break;
                        case 'month':
                            $dateTo->addMonth();
                            break;
                        case 'year':
                            $dateTo->addYear();
                            break;
                    }

                    if ($dateTo->diffInMinutes($dateFrom) < 20) {
                        $fail('Різниця між часом початку та кінця має буті не менше ніж 20 хвилин.'
                            .$dateTo->format('Y-m-d H:i:s')
                            .$dateFrom->format('Y-m-d H:i:s'));
                    }
                },
            ],
            'sensor' => 'required|string',
        ];
    }
}
