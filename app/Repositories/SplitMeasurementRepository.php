<?php

namespace App\Repositories;

use App\Models\SplitMeasurement;
use Carbon\Carbon;

class SplitMeasurementRepository
{
    public function create(array $splitData): void
    {
        SplitMeasurement::factory()->create([
            'timestamp_start' => $splitData['timestamp_start'],
            'timestamp_end' => $splitData['timestamp_end'],
            'sensor_id' => $splitData['sensor_id'],

            'AHTx0_temperature' => $splitData['AHTx0_temperature'],
            'AHTx0_humidity' => $splitData['AHTx0_humidity'],
            'BMP280_temperature' => $splitData['BMP280_temperature'],
            'BMP280_pressure' => $splitData['BMP280_pressure'],
            'MICS_6814_nh3' => $splitData['MICS_6814_nh3'],
            'MICS_6814_co' => $splitData['MICS_6814_co'],
            'MICS_6814_no2' => $splitData['MICS_6814_no2'],
            'RadKit_radiation' => $splitData['RadKit_radiation'],
            'ZE03_NH3_nh3' => $splitData['ZE03_NH3_nh3'],
            'ZE03_CL2_cl2' => $splitData['ZE03_CL2_cl2'],
            'SDS011_pm25' => $splitData['SDS011_pm25'],
            'SDS011_pm10' => $splitData['SDS011_pm10'],

            'AHTx0_temperature_ratio' => $splitData['AHTx0_temperature_ratio'],
            'AHTx0_humidity_ratio' => $splitData['AHTx0_humidity_ratio'],
            'BMP280_temperature_ratio' => $splitData['BMP280_temperature_ratio'],
            'BMP280_pressure_ratio' => $splitData['BMP280_pressure_ratio'],
            'MICS_6814_nh3_ratio' => $splitData['MICS_6814_nh3_ratio'],
            'MICS_6814_co_ratio' => $splitData['MICS_6814_co_ratio'],
            'MICS_6814_no2_ratio' => $splitData['MICS_6814_no2_ratio'],
            'RadKit_radiation_ratio' => $splitData['RadKit_radiation_ratio'],
            'ZE03_NH3_nh3_ratio' => $splitData['ZE03_NH3_nh3_ratio'],
            'ZE03_CL2_cl2_ratio' => $splitData['ZE03_CL2_cl2_ratio'],
            'SDS011_pm25_ratio' => $splitData['SDS011_pm25_ratio'],
            'SDS011_pm10_ratio' => $splitData['SDS011_pm10_ratio'],

            'interval_avg_time' => $splitData['interval_avg_time'],
            'is_20m' => $splitData['is_20m'],
            'is_daily' => $splitData['is_daily'],
        ]);
    }

    public function getLast20mTimeEcoCity()
    {
        return SplitMeasurement::where('is_20m', 1)->max('timestamp_end');
    }

    public function getFirst20mTimeEcoCity()
    {
        return SplitMeasurement::where('is_20m', 1)->min('timestamp_end');
    }

    public function getLastDayTimeEcoCity()
    {
        return SplitMeasurement::where('is_daily', 1)->max('timestamp_end');
    }

    public function getFirstDayTimeEcoCity()
    {
        return SplitMeasurement::where('is_daily', 1)->min('timestamp_end');
    }

    public function getSplit20mData($minTime, $maxTime)
    {
        return SplitMeasurement::select(
            'AHTx0_temperature',
            'AHTx0_humidity',
            'BMP280_temperature',
            'BMP280_pressure',
            'MICS_6814_nh3',
            'MICS_6814_co',
            'MICS_6814_no2',
            'RadKit_radiation',
            'ZE03_NH3_nh3',
            'ZE03_CL2_cl2',
            'SDS011_pm25',
            'SDS011_pm10',
            'AHTx0_temperature_ratio',
            'AHTx0_humidity_ratio',
            'BMP280_temperature_ratio',
            'BMP280_pressure_ratio',
            'MICS_6814_nh3_ratio',
            'MICS_6814_co_ratio',
            'MICS_6814_no2_ratio',
            'RadKit_radiation_ratio',
            'ZE03_NH3_nh3_ratio',
            'ZE03_CL2_cl2_ratio',
            'SDS011_pm25_ratio',
            'SDS011_pm10_ratio',
            'interval_avg_time'
        )
            ->whereBetween('interval_avg_time', [$minTime, $maxTime])
            ->where('is_20m', '1')
            ->orderBy('interval_avg_time')
            ->get();
    }

    public function getSplitDailyData($minTime, $maxTime)
    {
        return SplitMeasurement::select(
            'AHTx0_temperature',
            'AHTx0_humidity',
            'BMP280_temperature',
            'BMP280_pressure',
            'MICS_6814_nh3',
            'MICS_6814_co',
            'MICS_6814_no2',
            'RadKit_radiation',
            'ZE03_NH3_nh3',
            'ZE03_CL2_cl2',
            'SDS011_pm25',
            'SDS011_pm10',
            'AHTx0_temperature_ratio',
            'AHTx0_humidity_ratio',
            'BMP280_temperature_ratio',
            'BMP280_pressure_ratio',
            'MICS_6814_nh3_ratio',
            'MICS_6814_co_ratio',
            'MICS_6814_no2_ratio',
            'RadKit_radiation_ratio',
            'ZE03_NH3_nh3_ratio',
            'ZE03_CL2_cl2_ratio',
            'SDS011_pm25_ratio',
            'SDS011_pm10_ratio',
            'interval_avg_time'
        )
            ->whereBetween('interval_avg_time', [$minTime, Carbon::parse($maxTime)->setHour(23)])
            ->where('is_daily', '1')
            ->orderBy('interval_avg_time')
            ->get();
    }
}
