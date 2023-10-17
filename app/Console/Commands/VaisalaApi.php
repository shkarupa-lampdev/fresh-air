<?php

namespace App\Console\Commands;

use App\Repositories\Stations\StationsWithRawData\StationsVaisala\StationVaisalaBaseRepository;
use App\Repositories\VaisalaApiLogRepository;
use App\Services\VaisalaLogService;
use App\Services\VaisalaService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;
use SimpleXMLElement;

class VaisalaApi extends Command
{
    protected string $DefaultDateStart;
    protected VaisalaService $vaisalaService;
    protected VaisalaLogService $vaisalaLogService;
    protected VaisalaApiLogRepository $vaisalaApiLogRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:download-vaisala';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download sensor`s data from Vaisala using API';

    public function __construct(
        VaisalaService $vaisalaService,
        VaisalaLogService $vaisalaLogService,
        VaisalaApiLogRepository $vaisalaApiLogRepository
    ) {
        parent::__construct();
        $this->setDefaultDateStart();
        $this->vaisalaService = $vaisalaService;
        $this->vaisalaLogService = $vaisalaLogService;
        $this->vaisalaApiLogRepository = $vaisalaApiLogRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // TODO: remove to __construct
        $stations = $this->vaisalaService->listStations();

        foreach ($stations as $station) {
            $sensors = $this->vaisalaService->getSensorsByStationId($station);
            $apiKey = $this->vaisalaService->getApiKeyByStationId($station);
            $repository = new ($this->vaisalaService->getRepositoryName($station));

            foreach ($sensors as $sensor) {
                $startDate = $this->getDateStart($sensor);

                if (Carbon::now()->diffInDays(Carbon::parse($startDate)) > 7) {
                    $endDate = Carbon::parse($startDate)->copy()->addDays(7);
                } else {
                    $endDate = Carbon::now();
                }

                $this->vaisalaApiLogRepository->create([
                    'station_id' => $station,
                    'sensor_id' => $sensor,
                    'status' => 'processing',
                    'error_message' => null,
                    'date_start' => $startDate,
                    'date_end' => $endDate,
                ]);

                try {
                    $sensorData = $this->vaisalaService->getSensorData(
                        $station,
                        $sensor,
                        $apiKey,
                        $startDate,
                        $endDate,
                    );

                    if (!$sensorData) {
                        continue;
                    }

                    try {
                        $vaisalaSensorXMLData = new SimpleXMLElement($sensorData);
                    } catch (\Exception $ex) {
                        break;
                    }

                    $recordTime = '';
                    $recordValues = [];
                    foreach ($vaisalaSensorXMLData->measurements->meas as $meas) {
                        if ((string) $meas->timestamp !== $recordTime) {
                            $recordTime = (string) $meas->timestamp;

                            if ($recordValues !== []) {
                                $recordValues['measurement_time'] = $recordTime;

                                if (str_contains($sensor, "AQT530")) {
                                    $this->uploadAQT530Data($recordValues, $repository);
                                } elseif (str_contains($sensor, "WXT530")) {
                                    $this->uploadWXT530Data($recordValues, $repository);
                                }
                            }
                            $recordValues = [];
                        }

                        $recordValues[(string) $meas->type] = $this->updateValueBasedOnType(
                            (string) $meas->type,
                            (float) $meas->value
                        );
                    }
                    $this->vaisalaApiLogRepository->create([
                        'station_id' => $station,
                        'sensor_id' => $sensor,
                        'status' => 'success',
                        'error_message' => null,
                        'date_start' => $startDate,
                        'date_end' => $endDate,
                    ]);
                } catch (\Exception $ex) {
                    $this->vaisalaApiLogRepository->create([
                        'station_id' => $station,
                        'sensor_id' => $sensor,
                        'status' => 'fail',
                        'error_message' => $ex->getMessage(),
                        'date_start' => $startDate,
                        'date_end' => $endDate,
                    ]);
                    break;
                }
            }
        }
    }

    /**
     * Sets the DefaultDateStart value from configuration for downloading first Vaisala record.
     *
     * @return void
     */
    protected function setDefaultDateStart(): void
    {
        $this->DefaultDateStart = config('api.default-date-start');
    }
    /**
     * Updates the value based on its type.
     * Converts Pa to mm Hg
     * Converts µg/m³ to mg/m³
     *
     * @param string $type The type of the value.
     * @param float  $value The value to be updated.
     *
     * @return float The updated value.
     */
    private function updateValueBasedOnType(string $type, float $value): float
    {
        if ($type === 'Air pressure') {
            return $value * 100;
        }

        if (in_array($type, ['H2S', 'SO2', 'CO', 'NO2'])) {
            return $value / 1000;
        }

        return $value;
    }

    /**
     * Retrieves the start date for the given sensor.
     *
     * @param string $sensor The sensor's name.
     *
     * @return string The start date for the sensor.
     */
    private function getDateStart(string $sensor): string
    {
        $dateStart = $this->vaisalaLogService->getStationDateStart($sensor);

        return $dateStart ?: $this->DefaultDateStart;
    }

    /**
     * Uploads AQT530 to the repository.
     *
     * @param array $recordData The data to upload.
     * @param StationVaisalaBaseRepository $repository The repository for data upload.
     *
     *
     * @throws ValidationException If a validation error occurs during data upload.
     */
    private function uploadAQT530Data(array $recordData, StationVaisalaBaseRepository $repository): void
    {
        try {
            $repository->create($recordData);
        } catch (\Exception $e) {
            // if record is duplicate
            if ($e->getCode() == 23000) {
                return;
            }

            throw ValidationException::withMessages([
                'error' => $e->getCode(),
            ]);
        }
    }

    /**
     * Uploads WXT530 to the repository by updating existing record.
     *
     * @param array $recordData The data to upload.
     * @param StationVaisalaBaseRepository $repository The repository for data upload.
     *
     * @return void
     *
     * @throws ValidationException If a validation error occurs during data upload.
     */
    private function uploadWXT530Data(array $recordData, StationVaisalaBaseRepository $repository): void
    {
        try {
            $repository->update($recordData);
        } catch (\Exception $e) {

            throw ValidationException::withMessages([
                'error' => $e->getCode(),
            ]);
        }
    }
}
