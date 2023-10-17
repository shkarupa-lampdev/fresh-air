<?php

namespace App\Repositories;

use App\Models\SplitMeasurementUa171;
use Carbon\Carbon;

class SplitMeasurementUa171Repository
{
    public function create(array $splitData): void
    {
        SplitMeasurementUa171::factory()->create([
            'timestamp_start' => $splitData['timestamp_start'],
            'timestamp_end' => $splitData['timestamp_end'],

            'Humidity' => $splitData['humidity'] ?? null,
            'Temperature' => $splitData['temperature'] ?? null,
            'Pressure' => $splitData['pressure'] ?? null,
            'ammonia' => $splitData['ammonia'] ?? null,
            'carbon_oxide' => $splitData['carbon_oxide'] ?? null,
            'nitrogen_dioxide' => $splitData['nitrogen_dioxide'] ?? null,
            'radiation' => $splitData['radiation'] ?? null,
            'chlorine' => $splitData['chlorine'] ?? null,
            'sulfur_dioxide' => $splitData['sulfur_dioxide'] ?? null,
            'hydrogen_sulfide' => $splitData['hydrogen_sulfide'] ?? null,
            'ozone' => $splitData['ozone'] ?? null,
            'dust_PM1' => $splitData['dust_PM1'] ?? null,
            'dust_PM2_5' => $splitData['dust_PM2_5'] ?? null,
            'dust_PM10' => $splitData['dust_PM10'] ?? null,
            'max_wind_speed' => $splitData['max_wind_speed'] ?? null,
            'rain_intensity' => $splitData['rain_intensity'] ?? null,
            'wind_direction' => $splitData['wind_direction'] ?? null,
            'wind_speed' => $splitData['wind_speed'] ?? null,
            'rain_accumulation' => $splitData['rain_accumulation'] ?? null,

            'Humidity_ratio' => $splitData['Humidity_ratio'] ?? null,
            'Temperature_ratio' => $splitData['Temperature_ratio'] ?? null,
            'Pressure_ratio' => $splitData['Pressure_ratio'] ?? null,
            'ammonia_ratio' => $splitData['ammonia_ratio'] ?? null,
            'carbon_oxide_ratio' => $splitData['carbon_oxide_ratio'] ?? null,
            'nitrogen_dioxide_ratio' => $splitData['nitrogen_dioxide_ratio'] ?? null,
            'radiation_ratio' => $splitData['radiation_ratio'] ?? null,
            'chlorine_ratio' => $splitData['chlorine_ratio'] ?? null,
            'sulfur_dioxide_ratio' => $splitData['sulfur_dioxide_ratio'] ?? null,
            'hydrogen_sulfide_ratio' => $splitData['hydrogen_sulfide_ratio'] ?? null,
            'ozone_ratio' => $splitData['ozone_ratio'] ?? null,
            'dust_PM1_ratio' => $splitData['dust_PM1_ratio'] ?? null,
            'dust_PM2_5_ratio' => $splitData['dust_PM2_5_ratio'] ?? null,
            'dust_PM10_ratio' => $splitData['dust_PM10_ratio'] ?? null,
            'max_wind_speed_ratio' => $splitData['max_wind_speed_ratio'] ?? null,
            'rain_intensity_ratio' => $splitData['rain_intensity_ratio'] ?? null,
            'wind_direction_ratio' => $splitData['wind_direction_ratio'] ?? null,
            'wind_speed_ratio' => $splitData['wind_speed_ratio'] ?? null,
            'rain_accumulation_ratio' => $splitData['rain_accumulation_ratio'] ?? null,

            'interval_avg_time' => $splitData['interval_avg_time'],
            'is_20m' => true,
        ]);
    }

    public function createDailySplit(array $splitData, Carbon $startTime, Carbon $endTime): void
    {
        $options = [
            'timestamp_start' => $startTime->format('Y-m-d H:i:s'),
            'timestamp_end' => $endTime->format('Y-m-d H:i:s'),

            'interval_avg_time' => $startTime->copy()->addSeconds($startTime->diffInSeconds($endTime) / 2)->format('Y-m-d H:i:s'),
            'is_daily' => 1,
        ];

        SplitMeasurementUa171::factory()->create(array_merge($options, $splitData));
    }

    public function createMonthlySplit(array $splitData, Carbon $startTime, Carbon $endTime): void
    {
        $options = [
            'timestamp_start' => $startTime->format('Y-m-d H:i:s'),
            'timestamp_end' => $endTime->format('Y-m-d H:i:s'),

            'interval_avg_time' => $startTime->copy()->addSeconds($startTime->diffInSeconds($endTime) / 2)->format('Y-m-d H:i:s'),
            'is_monthly' => 1,
        ];

        SplitMeasurementUa171::factory()->create(array_merge($options, $splitData));
    }

    public function createAnnuallySplit(array $splitData, Carbon $startTime, Carbon $endTime): void
    {
        $options = [
            'timestamp_start' => $startTime->format('Y-m-d H:i:s'),
            'timestamp_end' => $endTime->format('Y-m-d H:i:s'),

            'interval_avg_time' => $startTime->copy()->addSeconds($startTime->diffInSeconds($endTime) / 2)->format('Y-m-d H:i:s'),
            'is_yearly' => 1,
        ];

        SplitMeasurementUa171::factory()->create(array_merge($options, $splitData));
    }

    public function getSplit(Carbon $startDate, Carbon $endDate): array
    {
        return SplitMeasurementUa171::select(SplitMeasurementUa171::raw('
            AVG(Humidity) AS humidity,
            AVG(Temperature) AS temperature,
            AVG(Pressure) AS pressure,
            AVG(ammonia) AS ammonia,
            AVG(carbon_oxide) AS carbon_oxide,
            AVG(nitrogen_dioxide) AS nitrogen_dioxide,
            AVG(radiation) AS radiation,
            AVG(chlorine) AS chlorine,
            AVG(dust_PM1) AS dust_PM1,
            AVG(dust_PM2_5) AS dust_PM2_5,
            AVG(dust_PM10) AS dust_PM10,
            AVG(ozone) AS ozone,
            AVG(sulfur_dioxide) AS sulfur_dioxide,
            AVG(hydrogen_sulfide) AS hydrogen_sulfide,
            AVG(max_wind_speed) AS max_wind_speed,
            AVG(rain_intensity) AS rain_intensity,
            AVG(wind_direction) AS wind_direction,
            AVG(wind_speed) AS wind_speed,
            AVG(rain_accumulation) AS rain_accumulation,
            AVG(Humidity_ratio) AS humidity_ratio,
            AVG(Temperature_ratio) AS temperature_ratio,
            AVG(Pressure_ratio) AS pressure_ratio,
            AVG(ammonia_ratio) AS ammonia_ratio,
            AVG(carbon_oxide_ratio) AS carbon_oxide_ratio,
            AVG(nitrogen_dioxide_ratio) AS nitrogen_dioxide_ratio,
            AVG(radiation_ratio) AS radiation_ratio,
            AVG(chlorine_ratio) AS chlorine_ratio,
            AVG(dust_PM1_ratio) AS dust_PM1_ratio,
            AVG(dust_PM2_5_ratio) AS dust_PM2_5_ratio,
            AVG(dust_PM10_ratio) AS dust_PM10_ratio,
            AVG(ozone_ratio) AS ozone_ratio,
            AVG(sulfur_dioxide_ratio) AS sulfur_dioxide_ratio,
            AVG(hydrogen_sulfide_ratio) AS hydrogen_sulfide_ratio,
            AVG(max_wind_speed_ratio) AS max_wind_speed_ratio,
            AVG(rain_intensity_ratio) AS rain_intensity_ratio,
            AVG(wind_direction_ratio) AS wind_direction_ratio,
            AVG(wind_speed_ratio) AS wind_speed_ratio,
            AVG(rain_accumulation_ratio) AS rain_accumulation_ratio
        '))->whereBetween('interval_avg_time', [$startDate, $endDate])
            ->first()
            ->toArray();
    }

    public function getSplit20mData($timeStart, $timeEnd)
    {
        return SplitMeasurementUa171::select(
            'humidity',
            'temperature',
            'pressure',
            'ammonia',
            'carbon_oxide',
            'nitrogen_dioxide',
            'radiation',
            'chlorine',
            'dust_PM1',
            'dust_PM2_5',
            'dust_PM10',
            'ozone',
            'sulfur_dioxide',
            'hydrogen_sulfide',
            'max_wind_speed',
            'rain_intensity',
            'wind_direction',
            'wind_speed',
            'rain_accumulation',
            'humidity_ratio',
            'temperature_ratio',
            'pressure_ratio',
            'ammonia_ratio',
            'carbon_oxide_ratio',
            'nitrogen_dioxide_ratio',
            'radiation_ratio',
            'chlorine_ratio',
            'dust_PM1_ratio',
            'dust_PM2_5_ratio',
            'dust_PM10_ratio',
            'ozone_ratio',
            'sulfur_dioxide_ratio',
            'hydrogen_sulfide_ratio',
            'max_wind_speed_ratio',
            'rain_intensity_ratio',
            'wind_direction_ratio',
            'wind_speed_ratio',
            'rain_accumulation_ratio',
            'interval_avg_time',
        )
            ->whereBetween('interval_avg_time', [$timeStart, $timeEnd])
            ->where('is_20m', '1')
            ->orderBy('interval_avg_time')
            ->get()
            ->toArray();
    }

    public function getLast20mTime()
    {
        return SplitMeasurementUa171::where('is_20m', 1)->max('timestamp_end');
    }

    public function getLastDailyTime()
    {
        return SplitMeasurementUa171::where('is_daily', 1)->max('timestamp_end');
    }

    public function getLastMonthlyTime()
    {
        return SplitMeasurementUa171::where('is_monthly', 1)->max('timestamp_end');
    }

    public function getLastAnnuallyTime()
    {
        return SplitMeasurementUa171::where('is_yearly', 1)->max('timestamp_end');
    }

    public function getFirst20mTime()
    {
        return SplitMeasurementUa171::where('is_20m', 1)->min('timestamp_end');
    }

    public function getReportData($dateFrom, $dateTo): array | bool
    {
        $splitData = SplitMeasurementUa171::select(
            'humidity',
            'temperature',
            'pressure',
            'ammonia',
            'carbon_oxide',
            'nitrogen_dioxide',
            'radiation',
            'chlorine',
            'dust_PM1',
            'dust_PM2_5',
            'dust_PM10',
            'ozone',
            'sulfur_dioxide',
            'hydrogen_sulfide',
            'max_wind_speed',
            'rain_intensity',
            'wind_direction',
            'wind_speed',
            'rain_accumulation',
            'humidity_ratio',
            'temperature_ratio',
            'pressure_ratio',
            'ammonia_ratio',
            'carbon_oxide_ratio',
            'nitrogen_dioxide_ratio',
            'radiation_ratio',
            'chlorine_ratio',
            'dust_PM1_ratio',
            'dust_PM2_5_ratio',
            'dust_PM10_ratio',
            'ozone_ratio',
            'sulfur_dioxide_ratio',
            'hydrogen_sulfide_ratio',
            'max_wind_speed_ratio',
            'rain_intensity_ratio',
            'wind_direction_ratio',
            'wind_speed_ratio',
            'rain_accumulation_ratio',
            'interval_avg_time'
        )
            ->whereBetween('interval_avg_time', [$dateFrom, $dateTo])
            ->get()
            ->toArray();

        if ($splitData === null) {
            return false;
        }

        $reportArray = [];
        foreach ($splitData as $key => $record) {
            $recordData = [];

            foreach ($record as $optionKey => $value) {
                if (!array_key_exists($optionKey . '_ratio', $record)) {
                    continue;
                }

                $recordData[$optionKey] = [
                    'value' => $value,
                    'ratio' => $record[$optionKey . '_ratio'],
                ];
            }
            $reportArray[$record['interval_avg_time']] = $recordData;
        }
        return $reportArray;
    }
}
