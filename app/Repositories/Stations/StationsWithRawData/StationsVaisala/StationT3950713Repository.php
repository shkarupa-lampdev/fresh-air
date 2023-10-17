<?php

namespace App\Repositories\Stations\StationsWithRawData\StationsVaisala;

class StationT3950713Repository extends StationVaisalaBaseRepository
{
    protected $modelName = 'App\Models\StationT3950713';

    protected int $stationId = 3950713;

    protected string $vaisalaStationId = 'T3950713';

    public function __construct()
    {
        $this->setOptions(config('csvfiles.measurement_options_T3950713'));
    }
}
