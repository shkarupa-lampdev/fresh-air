<?php

namespace App\Repositories\Stations\StationsWithRawData;

class Station1756Repository extends StationWithRawBaseRepository
{
    protected $modelName = 'App\Models\Station1756';

    protected int $stationId = 1756;

    public function __construct()
    {
        $this->setOptions(config('csvfiles.measurement_options_1756'));
    }
}
