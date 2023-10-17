<?php
/*
    |--------------------------------------------------------------------------
    | 1756 Sensor config
    |--------------------------------------------------------------------------
*/
$sensors1756=[
    'AHTx0=temperature(C)',
    'AHTx0=humidity(Rh)',
    'BMP280=temperature(C)',
    'BMP280=pressure(Pa)',
    'MICS-6814=nh3(ppm)',
    'MICS-6814=co(ppm)',
    'MICS-6814=no2(ppm)',
    'RadKit=radiation(uR/h)',
    'ZE03-NH3=nh3(ppm)',
    'ZE03-CL2=cl2(ppm)',
    'SDS011=pm25(ug/m3)',
    'SDS011=pm10(ug/m3)'
];
$measurementOptions1756 = [
    'Humidity',
    'Temperature',
    'Pressure',
    'NH₃',
    'CO',
    'NO₂',
    'RAD',
    'CL₂',
    'PM2.5',
    'PM10',
];
/*
    |--------------------------------------------------------------------------
    | 1753 Sensor config
    |--------------------------------------------------------------------------
*/
$measurementOptions1753 = [
    'Humidity',
    'Temperature',
    'Pressure',
    'NH₃',
    'CO',
    'NO₂',
    'PM2.5',
    'PM10',
];
$measurementUnits1753 = [
    '%',
    '°C',
    'Pa',
    'ppm',
    'ug/m3',
];
/*
    |--------------------------------------------------------------------------
    | 1748 Sensor config
    |--------------------------------------------------------------------------
*/
$measurementOptions1748 = [
    'Humidity',
    'Temperature',
    'Pressure',
    'NH₃',
    'CO',
    'NO₂',
    'PM2.5',
    'PM10',
];
$measurementUnits1748 = [
    '%',
    '°C',
    'Pa',
    'ppm',
    'ug/m3',
];

$measurementOptions = [
    'Humidity',
    'Temperature',
    'Pressure',
    'NH₃',
    'CO',
    'NO₂',
    'RAD',
    'CL₂',
    'PM2.5',
    'PM10',
    'O₃',
];

$measurementUnits = [
    '%',
    '°C',
    'Pa',
    'ppm',
    'uR/h',
    'ug/m3',
];
$measurementOptionsT395071 = [
    'Humidity',
    'Temperature',
    'Pressure',
    'NO2',
    'CO',
    'SO2',
    'H2S',
    'PM10',
    'PM2.5',
    'PM1',

    'Maximum wind speed',
    'Rain intensity',
    'Wind direction',
    'Wind speed',
    'Rain accumulation',
];

$measurementOptionsV0440346 = [
    'Humidity',
    'Temperature',
    'Pressure',
    'NO2',
    'CO',
    'SO2',
    'H2S',
    'PM10',
    'PM2.5',
    'PM1',
];
return [
    'measurement_sensor_order' => $sensors1756,

    'measurement_options_1756' => $measurementOptions1756,

    'measurement_options_1753' => $measurementOptions1753,

    'measurement_options_1748' => $measurementOptions1748,

    'measurement_options_T3950713' => $measurementOptionsT395071,

    'measurement_options_T3950716' => $measurementOptionsT395071,

    'measurement_options_V0440346' => $measurementOptionsV0440346,

     'stations' => [
         '1756' => [
             'validation_rules' => [
                 '0' => 'required|in:1756',
                 '1' => 'required|in:' . implode(',', $sensors1756),
                 '2' => 'required|in:' . implode(',', $measurementOptions),
                 '3' => 'required|in:' . implode(',', $measurementUnits),
                 '4' => 'required|numeric',
                 '5' => 'required|date_format:Y-m-d H:i:s',
                 ],
             'repository' => 'App\Repositories\Stations\StationsWithRawData\Station1756Repository',
         ],

         '1753' => [
             'validation_rules' => [
                 '0' => 'required|in:1753',
                 '1' => 'required|date_format:Y-m-d',
                 '2' => 'required|numeric|min:1|max:72',
                 '3' => 'required|numeric|min:1|max:20',
                 '4' => 'required|in:' . implode(',', $measurementOptions1753),
                 '5' => 'required|in:' . implode(',', $measurementUnits1753),
                 '6' => 'required|numeric',

             ],
             'repository' => 'App\Repositories\Stations\StationsWithSplitData\Station1753Repository',
         ],

         '1748' => [
             'validation_rules' => [
                 '0' => 'required|in:1748',
                 '1' => 'required|date_format:Y-m-d',
                 '2' => 'required|numeric|min:1|max:72',
                 '3' => 'required|numeric|min:1|max:20',
                 '4' => 'required|in:' . implode(',', $measurementOptions1748),
                 '5' => 'required|in:' . implode(',', $measurementUnits1748),
                 '6' => 'required|numeric',

             ],
             'repository' => 'App\Repositories\Stations\StationsWithSplitData\Station1748Repository',
         ],
     ]
 ];
