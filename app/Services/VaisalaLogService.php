<?php

namespace App\Services;

use App\Repositories\VaisalaApiLogRepository;
use Carbon\Carbon;

class VaisalaLogService
{
    public function __construct(protected VaisalaApiLogRepository $vaisalaApiLogRepository = new VaisalaApiLogRepository())
    {
    }

    /**
     * Get the start date for a Vaisala station based on the last successful API log entry.
     *
     * @param string $sensors The name of the sensor or station.
     *
     * @return Carbon|false Returns a Carbon instance representing the start date if found,
     *                     or false if no data is available.
     */

    public function getStationDateStart(string $sensors): Carbon | false
    {
        $lastSuccessTime = $this->vaisalaApiLogRepository->getSensorSuccessLastEndTime($sensors);

        if ($lastSuccessTime === null) {
            return false;
        }

        return Carbon::parse($lastSuccessTime);
    }
}
