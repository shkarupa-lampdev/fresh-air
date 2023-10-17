<?php

namespace App\Repositories\Stations\StationsWithSplitData;

class Station1753Repository extends StationWithSplitBaseRepository
{
    protected $modelName = 'App\Models\Station1753';

    protected int $stationId = 1753;

    public function __construct()
    {
        $this->setOptions(config('csvfiles.measurement_options_1753'));
    }
}
