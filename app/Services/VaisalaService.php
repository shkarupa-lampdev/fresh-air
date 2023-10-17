<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

class VaisalaService
{
    protected array $config;

    public function __construct()
    {
        $this->setConfig();
    }

    public function listStations(): array
    {
        return array_keys($this->config['stations']);
    }

    public function getSensorsByStationId(string $stationId): array
    {
        return $this->config['stations'][$stationId]['sensors'];
    }

    public function getApiKeyByStationId(string $stationId): string
    {
        return $this->config['stations'][$stationId]['key'];
    }

    public function getRepositoryName(string $stationId): string
    {
        return $this->config['stations'][$stationId]['repository'];
    }

    public function getSensorData(
        string $stationId,
        string $sensorId,
        string $apiKey,
        $timeStart,
        $timeEnd
    ) {
        return $this->call(
            [
                'd' => $stationId,
                's' => $sensorId,
                'k' => $apiKey,
                't0' => date('Y-m-d\TH:i:s', strtotime($timeStart)),
                't1' => date('Y-m-d\TH:i:s', strtotime($timeEnd)),
            ]
        );
    }

    protected function setConfig(): void
    {
        $this->config = config('api.vaisala');
    }

    protected function call($parameters, $requestMethod = 'GET')
    {
        $guzzleClient = new Client();

        try {
            $response = $guzzleClient->request($requestMethod, $this->config['endpoint'], [
                'query' => $parameters,
            ]);

            return $response->getBody()->getContents();
        } catch (GuzzleException | ClientException | ServerException $ex) {
            $requestResult = $ex->getResponse()->getBody()->getContents();
            return false;
        }
    }
}
