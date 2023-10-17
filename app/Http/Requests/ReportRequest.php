<?php

namespace App\Http\Requests;

use App\Services\SplitServices\SplitBaseService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    protected SplitBaseService $splitService;

    public function __construct(
        SplitBaseService $splitService,
    ) {
        parent::__construct();
        $this->splitService = $splitService;
    }

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
            'dateFrom' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $dateFrom = Carbon::parse($this->input('dateFrom'));

                    $locationService = $this->getLocationService();

                    $minAvailableTime = Carbon::parse($locationService->getRepository()->getFirst20mTime());

                    if ($minAvailableTime < $dateFrom) {
                        $fail('Мінімально допустима дата ' . $minAvailableTime->format('Y-m-d H:i:s'));
                    }
                },
            ],
            'dateTo' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $dateTo = Carbon::parse($this->input('dateTo'));

                    $locationService = $this->getLocationService();

                    $maxAvailableTime = Carbon::parse($locationService->getRepository()->getlast20mTime());

                    if ($maxAvailableTime < $dateTo) {
                        $fail('Мінімально допустима дата' . $maxAvailableTime->format('Y-m-d H:i:s'));
                    }
                },
                function ($attribute, $value, $fail) {
                    $min = Carbon::parse($this->input('dateFrom'));
                    $max = Carbon::parse($this->input('dateTo'));

                    if ($max->diffInMonths($min) < 3) {
                        $fail('Різниця між часом початку та кінця має буті не менше ніж 3 місяці.');
                    }
                },
            ],
            'city' => [
                'nullable',
                'string',
                'max:8',
            ],
        ];
    }

    private function getLocationService()
    {
        if ($this->input('city') === null) {
            return $this->splitService->getLocationService('kremenchuk');
        }
        return $this->splitService->getLocationService($this->input('city'));
    }
}
