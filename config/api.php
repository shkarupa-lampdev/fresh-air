<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Vaisala API integration
    |--------------------------------------------------------------------------
    | This config is the API credentials and station list for the Vaisala stations
    */
    'default-date-start' => '2021-11-29 08:08:33',

    'units' => [
        'temperature' => '°C',
        'humidity' => '%',
        'pressure' => 'Pa',
        'ammonia' => 'ppm',
        'carbon_oxide' => 'ppm',
        'nitrogen_dioxide' => 'ppm',
        'radiation' => 'uR/h',
        'chlorine' => 'ppm',
        'dust_PM1' => 'ug/m3',
        'dust_PM2_5' => 'ug/m3',
        'dust_PM10' => 'ug/m3',
        'ozone' => 'ppm',
        'sulfur_dioxide' => 'ppm',
        'hydrogen_sulfide' => 'ppm',
        'max_wind_speed' => 'm/s',
        'rain_intensity' => 'mm/h',
        'wind_direction' => '°',
        'wind_speed' => 'm/s',
        'rain_accumulation' => 'mm',
    ],

    'vaisala' => [
        'endpoint' => 'https://wxbeacon.vaisala.com/api/xml',
        // stations lists
        'stations' => [
//             sensors list
            'T3950713' => [
                'key' => env('VAISALA_API_KEY_T3950713'),
                'repository' => 'App\Repositories\Stations\StationsWithRawData\StationsVaisala\StationT3950713Repository',
                'sensors' => [
                    'AQT530-T4240745',
                    'WXT530-T3421081'
                ],
            ],
            'T3950716' => [
                'key' => env('VAISALA_API_KEY_T3950716'),
                'repository' => 'App\Repositories\Stations\StationsWithRawData\StationsVaisala\StationT3950716Repository',
                'sensors' => [
                    'AQT530-T4240744',
                    'WXT530-T3940844'
                ]
            ],
            'V0440346' => [
                'key' => env('VAISALA_API_KEY_V0440346'),
                'repository' => 'App\Repositories\Stations\StationsWithRawData\StationsVaisala\StationV0440346Repository',
                'sensors' => [
                    'AQT530-V0641076',
                ]
            ],
        ]
    ],
];
