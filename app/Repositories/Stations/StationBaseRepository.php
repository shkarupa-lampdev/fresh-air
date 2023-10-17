<?php

namespace App\Repositories\Stations;

use Carbon\Carbon;

class StationBaseRepository
{
    protected $modelName;

    protected int $stationId;

    protected array $options;

    public function toAssociativeArray(array $sensorAverageData, Carbon $startTime, Carbon $endTime): array
    {
        $ratio = $startTime->diffInMinutes($endTime->addSecond());

        $associativeArray = [
            'timestamp_start' => $startTime,
            'timestamp_end' => $endTime,
            'sensor_id' => $this->stationId,
        ];

        foreach ($sensorAverageData as $record) {
            $option = $this->convertOption($record['option']);

            $associativeArray[$option] = $record['average'] ?? 0;

            if (($record['ratio'] ?? 0) > $ratio) {
                $associativeArray[$option . '_ratio'] = ($record['ratio'] ?? 0) / ($ratio * 2);
                continue;
            }

            $associativeArray[$option . '_ratio'] = ($record['ratio'] ?? 0) / $ratio;
        }

        return $associativeArray;
    }

    protected function setOptions(array $sensors): void
    {
        $this->options = $sensors;
    }

    protected function convertOption(string $option): string
    {
        return match ($option) {
            'Relative humidity' => 'Humidity',
            'Air temperature' => 'Temperature',
            'Air pressure' => 'Pressure',
            'NH₃' => 'NH3',
            'NO₂' => 'NO2',
            'CL₂' => 'CL2',
            'O₃' => 'O3',
            default => $option,
        };
    }
}
