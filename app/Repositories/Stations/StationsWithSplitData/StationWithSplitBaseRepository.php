<?php

namespace App\Repositories\Stations\StationsWithSplitData;

use App\Repositories\Stations\StationBaseRepository;
use Carbon\Carbon;

class StationWithSplitBaseRepository extends StationBaseRepository
{
    public function create(array $measurementData): void
    {
        $this->modelName::factory()->create([
            'place_id' => $measurementData[0],
            'measurement_time' => $measurementData[1],
            'split_number' => $measurementData[2],
            'measurement_ratio' => $measurementData[3],
            'option' => $this->convertOption($measurementData[4]),
            'measurement_unit' => $measurementData[5],
            'measurement_value' => $measurementData[6],
        ]);
    }

    public function getAverage(Carbon $startTime, Carbon $endTime): array
    {
        $splitData = $this->modelName::where('measurement_time', '>=', $startTime->format('Y-m-d'))
            ->where('measurement_time', '<=', $endTime->format('Y-m-d'))
            ->where('split_number', '>=', $this->getSplitNumber($startTime))
            ->where('split_number', '<=', $this->getSplitNumber($endTime))
            ->whereIn('option', $this->options)
            ->groupBy('option')
            ->select('option', $this->modelName::raw('SUM(measurement_ratio) as ratio'), $this->modelName::raw('AVG(measurement_value) as average'))
            ->orderByRaw('FIELD(`option`, "' . implode('","', $this->options) . '")')
            ->get()
            ->toArray();

        return $this->toAssociativeArray($splitData, $startTime, $endTime);
    }

    public function getSplitNumber(Carbon $inputTime): int
    {
        $startOfDay = $inputTime->copy()->startOfDay();

        $minutesPassed = $startOfDay->diffInMinutes($inputTime);

        return floor($minutesPassed / 20);
    }

    public function getFirstMeasurementTime(): Carbon | false
    {
        $minMeasurementTime = $this->modelName::min('measurement_time');

        $minSplitNumber = $this->modelName::where('measurement_time', $minMeasurementTime)
            ->min('split_number');

        if ($minSplitNumber !== null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $minMeasurementTime . ' 00:00:00')
                ->addMinutes($minSplitNumber * 20);
        }

        return false;
    }

    public function getLastMeasurementTime(): Carbon | bool
    {
        $lastMeasurementTime = $this->modelName::max('measurement_time');

        $lastSplitNumber = $this->modelName::where('measurement_time', $lastMeasurementTime)
            ->max('split_number');

        if ($lastSplitNumber !== null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $lastMeasurementTime . ' 00:00:00')
                ->addMinutes($lastSplitNumber * 20);
        }
        return false;
    }

    public function deleteOldData(Carbon $lastSplitTime): bool
    {
        try {
            $this->modelName::where('measurement_time', '<', $lastSplitTime->copy()->subMonths(3))->
                where('split_number', '<', $this->getSplitNumber($lastSplitTime))->delete();
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }
}
