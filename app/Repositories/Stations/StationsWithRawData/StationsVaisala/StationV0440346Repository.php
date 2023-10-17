<?php

namespace App\Repositories\Stations\StationsWithRawData\StationsVaisala;

class StationV0440346Repository extends StationVaisalaBaseRepository
{
    protected $modelName = 'App\Models\StationV0440346';

    protected int $stationId = 0440346;

    protected string $vaisalaStationId = 'V0440346';

    public function __construct()
    {
        $this->setOptions(config('csvfiles.measurement_options_V0440346'));
    }
}
