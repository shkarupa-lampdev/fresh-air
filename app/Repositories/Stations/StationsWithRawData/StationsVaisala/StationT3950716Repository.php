<?php

namespace App\Repositories\Stations\StationsWithRawData\StationsVaisala;

class StationT3950716Repository extends StationVaisalaBaseRepository
{
    protected $modelName = 'App\Models\StationT3950716';

    protected int $stationId = 3950716;

    protected string $vaisalaStationId = 'T3950716';

    public function __construct()
    {
        $this->setOptions(config('csvfiles.measurement_options_T3950716'));
    }
}
