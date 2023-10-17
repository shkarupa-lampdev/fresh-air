<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationT3950716 extends Model
{
    use HasFactory;

    protected $table = 'station_T3950716';
    protected $fillable = [
        'measurement_time',

        'humidity',
        'temperature',
        'pressure',
        'carbon_oxide',
        'nitrogen_dioxide',
        'dust_PM2_5',
        'dust_PM10',
        'dust_PM1',
        'sulfur_dioxide',
        'hydrogen_sulfide',
        'max_wind_speed',
        'rain_intensity',
        'wind_direction',
        'wind_speed',
        'rain_accumulation',
    ];
}
