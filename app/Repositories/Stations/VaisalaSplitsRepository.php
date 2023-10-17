<?php

namespace App\Repositories\Stations;

use App\Models\VaisalaSplits;
use Carbon\Carbon;

class VaisalaSplitsRepository
{
    public function create20mSplit(array $splitData, Carbon $timeStart, Carbon $timeEnd): void
    {
        VaisalaSplits::factory()->create([
            'timestamp_start' => $timeStart,
            'timestamp_end' => $timeEnd,
            'sensor_id' => $splitData['sensor_id'],

            'Humidity' => $splitData['humidity'] ?? null,
            'Temperature' => $splitData['temperature'] ?? null,
            'Pressure' => $splitData['pressure'] ?? null,
            'carbon_oxide' => $splitData['carbon_oxide'] ?? null,
            'nitrogen_dioxide' => $splitData['nitrogen_dioxide'] ?? null,
            'sulfur_dioxide' => $splitData['sulfur_dioxide'] ?? null,
            'hydrogen_sulfide' => $splitData['hydrogen_sulfide'] ?? null,
            'dust_PM1' => $splitData['dust_PM1'] ?? null,
            'dust_PM2_5' => $splitData['dust_PM2_5'] ?? null,
            'dust_PM10' => $splitData['dust_PM10'] ?? null,
            'max_wind_speed' => $splitData['max_wind_speed'] ?? null,
            'rain_intensity' => $splitData['rain_intensity'] ?? null,
            'wind_direction' => $splitData['wind_direction'] ?? null,
            'wind_speed' => $splitData['wind_speed'] ?? null,
            'rain_accumulation' => $splitData['rain_accumulation'] ?? null,

            'Humidity_ratio' => $splitData['humidity_ratio'] ?? null,
            'Temperature_ratio' => $splitData['temperature_ratio'] ?? null,
            'Pressure_ratio' => $splitData['pressure_ratio'] ?? null,
            'carbon_oxide_ratio' => $splitData['carbon_oxide_ratio'] ?? null,
            'nitrogen_dioxide_ratio' => $splitData['nitrogen_dioxide_ratio'] ?? null,
            'sulfur_dioxide_ratio' => $splitData['sulfur_dioxide_ratio'] ?? null,
            'hydrogen_sulfide_ratio' => $splitData['hydrogen_sulfide_ratio'] ?? null,
            'dust_PM1_ratio' => $splitData['dust_PM1_ratio'] ?? null,
            'dust_PM2_5_ratio' => $splitData['dust_PM2_5_ratio'] ?? null,
            'dust_PM10_ratio' => $splitData['dust_PM10_ratio'] ?? null,
            'max_wind_speed_ratio' => $splitData['max_wind_speed_ratio'] ?? null,
            'rain_intensity_ratio' => $splitData['rain_intensity_ratio'] ?? null,
            'wind_direction_ratio' => $splitData['wind_direction_ratio'] ?? null,
            'wind_speed_ratio' => $splitData['wind_speed_ratio'] ?? null,
            'rain_accumulation_ratio' => $splitData['rain_accumulation_ratio'] ?? null,

            'interval_avg_time' => $timeStart->copy()->addMinutes(10)->format('Y-m-d H:i:s'),
            'is_20m' => true,
        ]);
    }

    public function createDailySplit(array $splitData, Carbon $timeStart, Carbon $timeEnd): void
    {
        VaisalaSplits::factory()->create([
            'timestamp_start' => $timeStart,
            'timestamp_end' => $timeEnd,
            'sensor_id' => $splitData['sensor_id'],

            'Humidity' => $splitData['humidity'] ?? null,
            'Temperature' => $splitData['temperature'] ?? null,
            'Pressure' => $splitData['pressure'] ?? null,
            'carbon_oxide' => $splitData['carbon_oxide'] ?? null,
            'nitrogen_dioxide' => $splitData['nitrogen_dioxide'] ?? null,
            'sulfur_dioxide' => $splitData['sulfur_dioxide'] ?? null,
            'hydrogen_sulfide' => $splitData['hydrogen_sulfide'] ?? null,
            'dust_PM1' => $splitData['dust_PM1'] ?? null,
            'dust_PM2_5' => $splitData['dust_PM2_5'] ?? null,
            'dust_PM10' => $splitData['dust_PM10'] ?? null,
            'max_wind_speed' => $splitData['max_wind_speed'] ?? null,
            'rain_intensity' => $splitData['rain_intensity'] ?? null,
            'wind_direction' => $splitData['wind_direction'] ?? null,
            'wind_speed' => $splitData['wind_speed'] ?? null,
            'rain_accumulation' => $splitData['rain_accumulation'] ?? null,

            'Humidity_ratio' => $splitData['humidity_ratio'] ?? null,
            'Temperature_ratio' => $splitData['temperature_ratio'] ?? null,
            'Pressure_ratio' => $splitData['pressure_ratio'] ?? null,
            'carbon_oxide_ratio' => $splitData['carbon_oxide_ratio'] ?? null,
            'nitrogen_dioxide_ratio' => $splitData['nitrogen_dioxide_ratio'] ?? null,
            'sulfur_dioxide_ratio' => $splitData['sulfur_dioxide_ratio'] ?? null,
            'hydrogen_sulfide_ratio' => $splitData['hydrogen_sulfide_ratio'] ?? null,
            'dust_PM1_ratio' => $splitData['dust_PM1_ratio'] ?? null,
            'dust_PM2_5_ratio' => $splitData['dust_PM2_5_ratio'] ?? null,
            'dust_PM10_ratio' => $splitData['dust_PM10_ratio'] ?? null,
            'max_wind_speed_ratio' => $splitData['max_wind_speed_ratio'] ?? null,
            'rain_intensity_ratio' => $splitData['rain_intensity_ratio'] ?? null,
            'wind_direction_ratio' => $splitData['wind_direction_ratio'] ?? null,
            'wind_speed_ratio' => $splitData['wind_speed_ratio'] ?? null,
            'rain_accumulation_ratio' => $splitData['rain_accumulation_ratio'] ?? null,

            'interval_avg_time' => $timeStart->copy()->addHours(12)->format('Y-m-d H:i:s'),
            'is_daily' => true,
        ]);
    }

    public function getSplit(string $dateFrom, string $dateTo, string $sensorId): array
    {
        return VaisalaSplits::whereBetween('interval_avg_time', [$dateFrom, $dateTo])
            ->where('sensor_id', $sensorId)
            ->where('is_20m', true)
            ->first()
            ->toArray();
    }

    public function getSplits(string $dateFrom, string $dateTo, string $sensorId): array
    {
        return VaisalaSplits::whereBetween('interval_avg_time', [$dateFrom, $dateTo])
            ->where('sensor_id', $sensorId)
            ->where('is_20m', true)
            ->get()
            ->toArray();
    }

    public function getMaxValues(string $dateFrom, string $dateTo, string $sensorId)
    {
        return  VaisalaSplits::select(
            VaisalaSplits::raw('MAX(nitrogen_dioxide) as max_nitrogen_dioxide'),
            VaisalaSplits::raw('MAX(sulfur_dioxide) as max_sulfur_dioxide'),
            VaisalaSplits::raw('MAX(carbon_oxide) as max_carbon_oxide'),
            VaisalaSplits::raw('MAX(hydrogen_sulfide) as max_hydrogen_sulfide'),
            VaisalaSplits::raw('MAX(dust_PM10) as max_dust_PM10'),
            VaisalaSplits::raw('MAX(dust_PM2_5) as max_dust_PM2_5'),
            VaisalaSplits::raw('MAX(temperature) as max_temperature'),
            VaisalaSplits::raw('MAX(humidity) as max_humidity'),
            VaisalaSplits::raw('MAX(pressure) as max_pressure'),
            VaisalaSplits::raw('MAX(wind_direction) as max_wind_direction'),
            VaisalaSplits::raw('MAX(wind_speed) as max_wind_speed'),
                )
            ->first()
            ->toArray();
    }

    public function getAvgValues(string $dateFrom, string $dateTo, string $sensorId)
    {
        return  VaisalaSplits::where('sensor_id', $sensorId)
                    ->select(
                        VaisalaSplits::raw('AVG(nitrogen_dioxide) as avg_nitrogen_dioxide'),
                        VaisalaSplits::raw('AVG(sulfur_dioxide) as avg_sulfur_dioxide'),
                        VaisalaSplits::raw('AVG(carbon_oxide) as avg_carbon_oxide'),
                        VaisalaSplits::raw('AVG(hydrogen_sulfide) as avg_hydrogen_sulfide'),
                        VaisalaSplits::raw('AVG(dust_PM10) as avg_dust_PM10'),
                        VaisalaSplits::raw('AVG(dust_PM2_5) as avg_dust_PM2_5'),
                        VaisalaSplits::raw('AVG(temperature) as avg_temperature'),
                        VaisalaSplits::raw('AVG(humidity) as avg_humidity'),
                        VaisalaSplits::raw('AVG(pressure) as avg_pressure'),
                        VaisalaSplits::raw('AVG(wind_direction) as avg_wind_direction'),
                        VaisalaSplits::raw('AVG(wind_speed) as avg_wind_speed'),
                    )
                ->first()
                ->toArray();
    }

    public function getLast20mDate(): string | null
    {
        return VaisalaSplits::where('is_20m', 1)->max('timestamp_end');
    }

    public function getFirst20mDate(): string | null
    {
        return VaisalaSplits::where('is_20m', 1)->min('timestamp_start');
    }

    public function getLastDailyDate(): string | null
    {
        return VaisalaSplits::where('is_daily', 1)->max('timestamp_end');
    }

    public function getFirstDailyDate(): string | null
    {
        return VaisalaSplits::where('is_daily', 1)->min('timestamp_start');
    }

    public function getLastSensorDate(string $sensor): string | null
    {
        return VaisalaSplits::where('is_20m', 1)->where('sensor_id', $sensor)->max('timestamp_end');
    }

    public function getFirstSensorDate(string $sensor): string | null
    {
        return VaisalaSplits::where('is_20m', 1)->where('sensor_id', $sensor)->min('timestamp_start');
    }
}
