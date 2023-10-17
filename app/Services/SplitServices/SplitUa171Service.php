<?php

namespace App\Services\SplitServices;

use App\Repositories\SplitMeasurementUa171Repository;
use App\Repositories\Stations\VaisalaSplitsRepository;
use Carbon\Carbon;

class SplitUa171Service extends SplitBaseService
{
    protected string $configLocationId = 'Ua171';

    public function __construct(
        protected SplitMeasurementUa171Repository $splitMeasurementUa171Repository,
        protected VaisalaSplitsRepository $vaisalaSplitsRepository,
    ) {
        parent::__construct();
    }

    public function get20split(Carbon $startTime, Carbon $endTime): array
    {
        $countValues = $sumValues = [
            'humidity' => 0,
            'temperature' => 0,
            'pressure' => 0,
            'ammonia' => 0,
            'carbon_oxide' => 0,
            'nitrogen_dioxide' => 0,
            'radiation' => 0,
            'chlorine' => 0,
            'sulfur_dioxide' => 0,
            'hydrogen_sulfide' => 0,
            'ozone' => 0,
            'dust_PM1' => 0,
            'dust_PM2_5' => 0,
            'dust_PM10' => 0,
            'max_wind_speed' => 0,
            'rain_intensity' => 0,
            'wind_direction' => 0,
            'wind_speed' => 0,
            'rain_accumulation' => 0,

            'humidity_ratio' => 0,
            'temperature_ratio' => 0,
            'pressure_ratio' => 0,
            'ammonia_ratio' => 0,
            'carbon_oxide_ratio' => 0,
            'nitrogen_dioxide_ratio' => 0,
            'radiation_ratio' => 0,
            'chlorine_ratio' => 0,
            'sulfur_dioxide_ratio' => 0,
            'hydrogen_sulfide_ratio' => 0,
            'ozone_ratio' => 0,
            'dust_PM1_ratio' => 0,
            'dust_PM2_5_ratio' => 0,
            'dust_PM10_ratio' => 0,
            'max_wind_speed_ratio' => 0,
            'rain_intensity_ratio' => 0,
            'wind_direction_ratio' => 0,
            'wind_speed_ratio' => 0,
            'rain_accumulation_ratio' => 0,
        ];
        foreach ($this->repositoryList as $repositoryName) {
            $repository = new $repositoryName();
            $averageValues = $repository->getAverage($startTime, $endTime->copy());

            if (str_contains($repositoryName, 'App\Repositories\Stations\StationsWithRawData\StationsVaisala')) {
                $averageValues['sensor_id'] = $repository->getVaisalaStationId();
                $this->vaisalaSplitsRepository->create20mSplit($averageValues, $startTime, $endTime->copy());
            }
            // Fill $averageValues sum of data
            foreach ($averageValues as $key => $value) {
                if (isset($sumValues[$key])) {
                    $sumValues[$this->convertOptionToFullName($key)] += $value;
                    $countValues[$this->convertOptionToFullName($key)]++;
                }
            }
        }

        // Calculate the average value for each parameter
        $averageResults = [];
        foreach ($sumValues as $key => $sum) {
            if ($countValues[$key] > 0) {
                $average = $sum / $countValues[$key];
                $averageResults[$key] = $average;
            }
        }
        $options = [
            'timestamp_start' => $startTime->format('Y-m-d H:i:s'),
            'timestamp_end' => $endTime->format('Y-m-d H:i:s'),
            'interval_avg_time' => $startTime->copy()->addMinutes(10)->format('Y-m-d H:i:s'),
            'is_20m' => true,
        ];

        return array_merge($averageResults, $options);
    }

    /**
     * Check if the last 20 minutes represent a split measurement.
     *
     * @return bool returns true if the last 20 minutes represent a split measurement, false otherwise
     */
    public function isLast20mSplit(): bool
    {
        $lastSplit = $this->splitMeasurementUa171Repository->getLast20mTime();

        if ($lastSplit === null) {
            return false;
        }

        $earliestMeasurement = $this->getMinTimeFromLatest();

        if ($earliestMeasurement->diffInMinutes($lastSplit) < 20) {
            return true;
        }

        return false;
    }

    /**
     * Check if the last daily represent a split measurement.
     *
     * @return bool returns true if the last daily represent a split measurement, false otherwise
     */
    public function isLastDailySplit(): bool
    {
        $lastSplit = $this->splitMeasurementUa171Repository->getLastDailyTime();

        if ($lastSplit === null) {
            return false;
        }

        $last20m = $this->getLastDaily();

        if ($last20m->diffInHours($lastSplit) < 24) {
            return true;
        }

        return false;
    }

    /**
     * Check if the last monthly represent a split measurement.
     *
     * @return bool returns true if the last monthly represent a split measurement, false otherwise
     */
    public function isLastMonthlySplit(): bool
    {
        $lastSplit = $this->splitMeasurementUa171Repository->getLastMonthlyTime();

        if ($lastSplit === null) {
            return false;
        }

        $last20m = $this->getLastMonthly();

        if ($last20m->diffInMonths($lastSplit) <= 1) {
            return true;
        }

        return false;
    }

    /**
     * Check if the last annually represent a split measurement.
     *
     * @return bool returns true if the last annually represent a split measurement, false otherwise
     */
    public function isLastAnnuallySplit(): bool
    {
        $lastSplit = $this->splitMeasurementUa171Repository->getLastAnnuallyTime();

        if ($lastSplit === null) {
            return false;
        }

        $last20m = $this->getLastAnnually();

        if ($last20m->diffInYears($lastSplit) <= 1) {
            return true;
        }

        return false;
    }

    /**
     * Get the minimum time from the latest measurements of all repositories.
     *
     * @return Carbon returns a Carbon object with the minimum time
     */
    public function getMinTimeFromLatest(): Carbon
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
     * Get the time of the first record from the measurements of all repositories.
     *
     * @return Carbon returns a Carbon object with the time of the first record
     */
    public function getFirstRecordTime(): Carbon
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

    /**
     * Get the last time of 20 minute split or get first record from the measurements of all repositories.
     *
     * @return Carbon returns a Carbon object with the time of the last 20 minutes
     */
    public function getLast20m(): Carbon
    {
        $last20MinTime = $this->splitMeasurementUa171Repository->getLast20mTime();

        if ($last20MinTime !== null) {
            return Carbon::parse($last20MinTime)->copy()->addSecond();
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
     * Get the last time of daily split or get first record from the measurements of all repositories.
     *
     * @return Carbon returns a Carbon object with the time of the last daily split
     */
    public function getLastDaily(): Carbon
    {
        $lastDailyTime = $this->splitMeasurementUa171Repository->getLastDailyTime();

        if ($lastDailyTime !== null) {
            return Carbon::parse($lastDailyTime)->addSecond();
        }

        return Carbon::parse($this->getFirstRecordTime())->setTime(0, 0);
    }

    /**
     * Get the last time of monthly split or get first record from the measurements of all repositories.
     *
     * @return Carbon returns a Carbon object with the time of the last monthly split
     */
    public function getLastMonthly(): Carbon
    {
        $lastMonthlyTime = $this->splitMeasurementUa171Repository->getLastMonthlyTime();

        if ($lastMonthlyTime !== null) {
            return Carbon::parse($lastMonthlyTime)->copy()->addSecond();
        }

        $firstRecord = Carbon::parse($this->getFirstRecordTime());

        return $firstRecord->copy()->firstOfMonth();
    }

    /**
     * Get the last time of annually split or get first record from the measurements of all repositories.
     *
     * @return Carbon returns a Carbon object with the time of the last annually split
     */
    public function getLastAnnually(): Carbon
    {
        $lastAnnuallyTime = $this->splitMeasurementUa171Repository->getLastAnnuallyTime();

        if ($lastAnnuallyTime !== null) {
            return Carbon::parse($lastAnnuallyTime)->copy()->addSecond();
        }

        $firstRecord = Carbon::parse($this->getFirstRecordTime());

        return $firstRecord->copy()->firstOfYear();
    }

    /**
     * Get the repository instance for split measurements associated.
     *
     * @return SplitMeasurementUa171Repository The repository instance.
     */
    public function getRepository(): SplitMeasurementUa171Repository
    {
        return $this->splitMeasurementUa171Repository;
    }

    /**
     * Delete old records from associated repositories.
     *
     * This method iterates through the list of repository classes and deletes old records
     * based on the timestamp of the last 20-minute interval.
     */
    public function deleteOldRecords(): void
    {
        $last20mTime = $this->getLast20m();
        foreach ($this->repositoryList as $repositoryClass) {
            $repository = new $repositoryClass();
            $repository->deleteOldData($last20mTime);
        }
    }
}
