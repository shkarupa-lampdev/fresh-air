<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaisalaSplits extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'vaisala_splits';

    protected $fillable = [
        'timestamp_start',
        'timestamp_end',

        'humidity',
        'temperature',
        'pressure',
        'carbon_oxide',
        'nitrogen_dioxide',
        'dust_PM1',
        'dust_PM2_5',
        'dust_PM10',
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
        'carbon_oxide_ratio',
        'nitrogen_dioxide_ratio',
        'dust_PM1_ratio',
        'dust_PM2_5_ratio',
        'dust_PM10_ratio',
        'sulfur_dioxide_ratio',
        'hydrogen_sulfide_ratio',
        'max_wind_speed_ratio',
        'rain_intensity_ratio',
        'wind_direction_ratio',
        'wind_speed_ratio',
        'rain_accumulation_ratio',

        'interval_avg_time',
        'is_20m',
        'is_daily',
        'is_monthly',
        'is_yearly',
    ];
}
