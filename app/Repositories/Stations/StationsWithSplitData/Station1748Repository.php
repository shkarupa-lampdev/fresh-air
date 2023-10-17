<?php

namespace App\Repositories\Stations\StationsWithSplitData;

class Station1748Repository extends StationWithSplitBaseRepository
{
    protected $modelName = 'App\Models\Station1748';

    protected int $stationId = 1748;

    public function __construct()
    {
        $this->setOptions(config('csvfiles.measurement_options_1748'));
    }
}
