<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SplitMeasurement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'split_measurement';
    protected $fillable = [
        'timestamp_start',
        'timestamp_end',
        'sensor_id',

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

        'interval_avg_time',
        'is_20m',
        'is_daily',
    ];
}
