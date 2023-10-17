<?php

namespace App\Services\SplitServices;

/**
 * Class SplitService.
 *
 * This class provides methods for making measurement splits.
 */
class SplitBaseService
{
    protected array $repositoryList = [];

    /** @var string Id of location */
    protected string $configLocationId = 'Ua171';

    public function __construct()
    {
        $this->setStationRepositories();
    }

    public function getLocationServices(): array
    {
        $locationIds = array_keys(config('locations'));

        $locationServices = [];

        foreach ($locationIds as $lId) {
            $locationClassServiceName = 'App\Services\SplitServices\Split' . ucfirst($lId) . 'Service';

            if (class_exists($locationClassServiceName)) {
                $locationServices[] = new $locationClassServiceName();
            }
        }

        return $locationServices;
    }

    public function getLocationService(string $city)
    {
        $locations = config('locations');

        foreach ($locations as $Id => $location) {
            if ($location['name'] === $city) {
                $locationClassServiceName = 'App\Services\SplitServices\Split' . ucfirst($Id) . 'Service';
                return class_exists($locationClassServiceName) ? new $locationClassServiceName() : false;
            }
        }
        return false;
    }

    public function getReportData($dateFrom, $dateTo): array
    {
        $splitData = $this->getRepository()->getReportData($dateFrom, $dateTo);
        return [
            'units' => config('api.units'),
            'records' => $splitData,
        ];
    }

    protected function setStationRepositories(): void
    {
        $stations = config('locations.' . $this->configLocationId . '.stations');
        $stationRepositoryList = [];

        foreach (((array) $stations ?? []) as $station) {
            if ($station['is_data_split']) {
                $stationRepositoryList[] = 'App\Repositories\Stations\StationsWithSplitData\Station' . $station['id'] . 'Repository';
            } elseif ($station['is_vaisala'] ?? false) {
                $stationRepositoryList[] = 'App\Repositories\Stations\StationsWithRawData\StationsVaisala\Station' . $station['id'] . 'Repository';
            } else {
                $stationRepositoryList[] = 'App\Repositories\Stations\StationsWithRawData\Station' . $station['id'] . 'Repository';
            }
        }

        $this->repositoryList = $stationRepositoryList;
    }

    protected function convertOptionToFullName(string $option): string
    {
        return match ($option) {
            "Humidity" => 'humidity',
            "Temperature" => 'temperature',
            "Pressure" => 'pressure',
            "NH₃" => 'ammonia',
            "CO" => 'carbon_oxide',
            "NO₂" => 'nitrogen_dioxide',
            "RAD" => 'radiation',
            "CL₂" => 'chlorine',
            'SO2' => 'sulfur_dioxide',
            'H2S' => 'hydrogen_sulfide',
            "O₃" => 'ozone',
            'PM1' => 'dust_PM1',
            "PM2.5" => 'dust_PM2_5',
            "PM10" => 'dust_PM10',
            'Maximum wind speed' => 'max_wind_speed',
            'Rain intensity' => 'rain_intensity',
            'Wind direction' => 'wind_direction',
            'Wind speed' => 'wind_speed',
            'Rain accumulation' => 'rain_accumulation',
            default => $option,
        };
    }

    protected function getRepository()
    {
    }
}
