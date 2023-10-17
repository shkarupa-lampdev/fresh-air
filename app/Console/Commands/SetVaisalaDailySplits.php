<?php

namespace App\Console\Commands;

use App\Repositories\Stations\VaisalaSplitsRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SetVaisalaDailySplits extends Command
{
    protected VaisalaSplitsRepository $vaisalaSplitsRepository;

    protected array $repositoryList = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'splits:vaisala-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store vaisala daily splits';

    public function __construct(
        VaisalaSplitsRepository $vaisalaSplitsRepository,
    ) {
        parent::__construct();
        $this->setRepositoryList();
        $this->vaisalaSplitsRepository = $vaisalaSplitsRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while (!$this->isLastVaisalaDailySplit()) {
            $startTime = Carbon::parse($this->getLastDailySplit());
            foreach ($this->repositoryList as $repositoryName) {
                $repository = new $repositoryName();
                $averageValues = $repository->getAverage($startTime, $startTime->copy()->addDay());

                $averageValues['sensor_id'] = $repository->getVaisalaStationId();
                $this->vaisalaSplitsRepository->createDailySplit($averageValues, $startTime, $startTime->copy()->addDay());
            }
        }
    }

    /**
     * Sets the repository list from the configuration.
     */
    protected function setRepositoryList(): void
    {
        $stations = config('api.vaisala.stations');

        foreach ($stations as $station) {
            $this->repositoryList[] = $station['repository'];
        }
    }

    /**
     * Checks if the last Vaisala split is within the last day.
     *
     * @return bool Returns true if the last split is within the last day, otherwise false.
     */
    protected function isLastVaisalaDailySplit(): bool
    {
        $lastSplit = $this->vaisalaSplitsRepository->getLastDailyDate();

        if ($lastSplit === null) {
            return false;
        }

        return $this->getMinTimeFromLatest()->diffInHours($lastSplit) < 24;
    }

    /**
     * Returns the minimum timestamp from the latest measurements across all repositories.
     *
     * @return Carbon The minimum timestamp from the latest measurements.
     */
    protected function getMinTimeFromLatest(): Carbon
    {
        $minTime = Carbon::now();
        foreach ($this->repositoryList as $repository) {
            $repositoryClass = new $repository();

            $measurementLastTime = $repositoryClass->getLastMeasurementTime();

            if (!$measurementLastTime) {
                continue;
            }

            if ($minTime > $measurementLastTime) {
                $minTime = $measurementLastTime;
            }
        }

        return $minTime;
    }

    /**
     * Gets the timestamp of the last day for Vaisala splits.
     *
     * If there aren't any records, it calculates the first day interval based
     * on the timestamp of the first recorded measurement from all repositories.
     *
     * @return Carbon The timestamp of the last day interval.
     */
    protected function getLastDailySplit(): Carbon
    {
        $lastDailyMinTime = $this->vaisalaSplitsRepository->getLastDailyDate();

        if ($lastDailyMinTime !== null) {
            return Carbon::parse($lastDailyMinTime);
        }

        return Carbon::parse($this->getFirstRecordTime())->setTime(0, 0);
    }


    /**
     * Gets the timestamp of the first recorded measurement across all repositories.
     *
     * This method returns the minimum timestamp from the first recorded measurements.
     * It is used to determine the starting point for calculating Vaisala splits.
     *
     * @return Carbon The timestamp of the first recorded measurement.
     */
    protected function getFirstRecordTime(): Carbon
    {
        $firstTime = Carbon::now();

        foreach ($this->repositoryList as $repository) {
            $repositoryClass = new $repository();

            $measurementLastTime = $repositoryClass->getFirstMeasurementTime();

            if ($measurementLastTime && $firstTime > $measurementLastTime) {
                $firstTime = $measurementLastTime;
            }
        }

        return $firstTime;
    }
}
