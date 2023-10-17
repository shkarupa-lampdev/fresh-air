<?php

namespace App\Repositories\Stations\StationsWithRawData\StationsVaisala;

use App\Repositories\Stations\StationsWithRawData\StationWithRawBaseRepository;
use Carbon\Carbon;

class StationVaisalaBaseRepository extends StationWithRawBaseRepository
{
    protected string $vaisalaStationId;

    public function create(array $measurementData): void
    {
        $this->modelName::factory()->create([
            'measurement_time' => $measurementData['measurement_time'],

            'humidity' => $measurementData['Relative humidity'] ?? null,
            'temperature' => $measurementData['Air temperature'] ?? null,
            'pressure' => $measurementData['Air pressure'] ?? null,
            'carbon_oxide' => $measurementData['CO'] ?? null,
            'nitrogen_dioxide' => $measurementData['NO2'] ?? null,
            'dust_PM2_5' => $measurementData['PM2.5'] ?? null,
            'dust_PM10' => $measurementData['PM10'] ?? null,
            'dust_PM1' => $measurementData['PM1'] ?? null,
            'sulfur_dioxide' => $measurementData['SO2'] ?? null,
            'hydrogen_sulfide' => $measurementData['H2S'] ?? null,
            'max_wind_speed' => $measurementData['Maximum wind speed'] ?? null,
            'rain_intensity' => $measurementData['Rain intensity'] ?? null,
            'wind_direction' => $measurementData['Wind direction'] ?? null,
            'wind_speed' => $measurementData['Wind speed'] ?? null,
            'rain_accumulation' => $measurementData['Rain accumulation'] ?? null,
        ]);
    }

    public function getAverage(Carbon $startTime, Carbon $endTime): array
    {
        return $this->updateRatioValue($this->modelName::select(
            $this->modelName::raw('
        AVG(humidity) AS humidity,
        AVG(temperature) AS temperature,
        AVG(pressure) AS pressure,
        AVG(carbon_oxide) AS carbon_oxide,
        AVG(nitrogen_dioxide) AS nitrogen_dioxide,
        AVG(dust_PM1) AS dust_PM1,
        AVG(dust_PM2_5) AS dust_PM2_5,
        AVG(dust_PM10) AS dust_PM10,
        AVG(sulfur_dioxide) AS sulfur_dioxide,
        AVG(hydrogen_sulfide) AS hydrogen_sulfide,
        AVG(max_wind_speed) AS max_wind_speed,
        AVG(rain_intensity) AS rain_intensity,
        AVG(wind_direction) AS wind_direction,
        AVG(wind_speed) AS wind_speed,
        AVG(rain_accumulation) AS rain_accumulation
    '),
            $this->modelName::raw('
        COUNT(humidity) as humidity_ratio,
        COUNT(temperature) as temperature_ratio,
        COUNT(pressure) as pressure_ratio,
        COUNT(carbon_oxide) as carbon_oxide_ratio,
        COUNT(nitrogen_dioxide) as nitrogen_dioxide_ratio,
        COUNT(dust_PM1) as dust_PM1_ratio,
        COUNT(dust_PM2_5) as dust_PM2_5_ratio,
        COUNT(dust_PM10) as dust_PM10_ratio,
        COUNT(sulfur_dioxide) as sulfur_dioxide_ratio,
        COUNT(hydrogen_sulfide) as hydrogen_sulfide_ratio,
        COUNT(max_wind_speed) as max_wind_speed_ratio,
        COUNT(rain_intensity) as rain_intensity_ratio,
        COUNT(wind_direction) as wind_direction_ratio,
        COUNT(wind_speed) as wind_speed_ratio,
        COUNT(rain_accumulation) as rain_accumulation_ratio
    ')
        )->whereBetween('measurement_time', [$startTime, $endTime->copy()->subSecond()])
            //subSecond() is needed for making 10:00:00 - 10:09:59 interval
            ->first()
            ->toArray()
        , $startTime->diffInMinutes($endTime));

    }

    /**
     * Updates ratio values in an associative array based on the given records count.
     *
     * This function iterates through the provided associative array, checking for keys
     * ending with '_ratio' and numeric values. It then updates each valid ratio value by
     * dividing it by the provided records count.
     *
     * @param array $ratioArray An associative array containing ratio values to be updated.
     * @param int $recordsCount The expected count of records to calculate ratios.
     *
     * @return array The updated associative array with ratio values adjusted for the provided records count.
     */
    public function updateRatioValue(array $ratioArray, int $recordsCount):array
    {
        foreach ($ratioArray as $key => $value) {
            if (str_contains($key, '_ratio') && is_numeric($value)) {
                $ratioArray[$key] = $value / $recordsCount;
            }
        }

        return $ratioArray;
    }

    public function update(array $measurementData): void
    {
        $record = $this->modelName::where('measurement_time', $measurementData['measurement_time'])->first();

        if ($record) {
            $record->update([
                'max_wind_speed' => $measurementData['Maximum wind speed'] ?? null,
                'rain_intensity' => $measurementData['Rain intensity'] ?? null,
                'wind_direction' => $measurementData['Wind direction'] ?? null,
                'wind_speed' => $measurementData['Wind speed'] ?? null,
                'rain_accumulation' => $measurementData['Rain accumulation'] ?? null,
            ]);
        }
    }

    public function getRecordsByTime(string $dateFrom, string $dateTo): array
    {
        return $this->modelName::whereBetween('measurement_time', [$dateFrom, $dateTo])
            ->get()
            ->toArray();
    }

    public function getVaisalaStationId(): string
    {
        return $this->vaisalaStationId;
    }
}
