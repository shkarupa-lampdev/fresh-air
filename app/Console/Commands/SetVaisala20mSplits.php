<?php

namespace App\Console\Commands;

use App\Repositories\Stations\VaisalaSplitsRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SetVaisala20mSplits extends Command
{
    protected VaisalaSplitsRepository $vaisalaSplitsRepository;

    protected array $repositoryList = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'splits:vaisala-20m';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store vaisala splits for 20m frames';

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
        while (!$this->isLastVaisala20mSplit()) {
            $startTime = Carbon::parse($this->getLast20m());
            foreach ($this->repositoryList as $repositoryName) {
                $repository = new $repositoryName();
                $averageValues = $repository->getAverage($startTime, $startTime->copy()->addMinutes(20));

                $averageValues['sensor_id'] = $repository->getVaisalaStationId();
                $this->vaisalaSplitsRepository->create20mSplit($averageValues, $startTime, $startTime->copy()->addMinutes(20));
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
     * Checks if the last Vaisala split is within the last 20 minutes.
     *
     * @return bool Returns true if the last split is within the last 20 minutes, otherwise false.
     */
    protected function isLastVaisala20mSplit(): bool
    {
        $lastSplit = $this->vaisalaSplitsRepository->getLast20mDate();

        if ($lastSplit === null) {
            return false;
        }

        return $this->getMinTimeFromLatest()->diffInMinutes($lastSplit) < 20;
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
     * Gets the timestamp of the last 20-minute interval for Vaisala splits.
     *
     * If there aren't any records, it calculates the first 20-minute interval
     * based on the timestamp of the first recorded measurement from all repositories.
     *
     * @return Carbon The timestamp of the last 20-minute interval.
     */
    protected function getLast20m(): Carbon
    {
        $last20MinTime = $this->vaisalaSplitsRepository->getLast20mDate();

        if ($last20MinTime !== null) {
            return Carbon::parse($last20MinTime);
        }

        $first20m = Carbon::parse($this->getFirstRecordTime());

        if ($first20m->minute <= 19) {
            return $first20m->setMinute(0)->setSecond(0);
        }
        if ($first20m->minute >= 40) {
            return $first20m->setMinute(40)->setSecond(0);
        } else {
            return $first20m->setMinute(20)->setSecond(0);
        }
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
