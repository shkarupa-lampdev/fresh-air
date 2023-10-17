<?php

namespace App\Repositories\Stations\StationsWithRawData;

use App\Repositories\Stations\StationBaseRepository;
use Carbon\Carbon;

class StationWithRawBaseRepository extends StationBaseRepository
{
    public function create(array $measurementData): void
    {
        $this->modelName::factory()->create([
            'place_id' => $measurementData[0],
            'measurement_sensor' => $measurementData[1],
            'option' => $this->convertOption($measurementData[2]),
            'measurement_unit' => $measurementData[3],
            'measurement_value' => $measurementData[4],
            'measurement_time' => $measurementData[5],
        ]);
    }

    public function getAverage(Carbon $startTime, Carbon $endTime): array
    {
        $splitData = $this->modelName::where('measurement_time', '>=', $startTime)
            ->where('measurement_time', '<=', $endTime)
            ->whereIn('option', $this->options)
            ->groupBy('option')
            ->select('option', $this->modelName::raw('AVG(measurement_value) as average'), $this->modelName::raw('COUNT(*) as ratio'))
            ->orderByRaw('FIELD(`option`, "' . implode('","', $this->options) . '")')
            ->get()
            ->toArray();

        return $this->toAssociativeArray($splitData, $startTime, $endTime);
    }

    public function getFirstMeasurementTime(): Carbon | false
    {
        $firstTimeRecord = $this->modelName::min('measurement_time');

        if ($firstTimeRecord === null) {
            return false;
        }
        return Carbon::parse($firstTimeRecord);
    }

    public function getLastMeasurementTime(): Carbon | false
    {
        $lastTimeRecord = $this->modelName::max('measurement_time');

        if ($lastTimeRecord === null) {
            return false;
        }
        return Carbon::parse($lastTimeRecord);
    }

    public function deleteOldData(Carbon $lastSplitTime): bool
    {
        try {
            $this->modelName::where('measurement_time', '<', $lastSplitTime->copy()->subMonths(3))->delete();
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }
}
