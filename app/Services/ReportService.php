<?php

namespace App\Services;

use App\Http\Controllers\BaseController;
use App\Http\Requests\FirstTypeReportRequest;
use App\Repositories\Stations\VaisalaSplitsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpWord\TemplateProcessor;

/**
 * Class ReportService
 *
 * This class provides functionality for generating reports and data manipulation related to Vaisala stations.
 *
 * @package App\Services
 */
class ReportService extends BaseController
{
    /**
     * The list of first report values mapping to their corresponding split data keys.
     */
    protected const FIRST_REPORT_VALUES = [
        'Pressure' => 'pressure',
        'Temperature' => 'temperature',
        'Humidity' => 'humidity',
        'WindDirection' => 'wind_direction',
        'WindSpeed' => 'wind_speed',
        'CO' => 'carbon_oxide',
        'NO2' => 'nitrogen_dioxide',
        'SO2' => 'sulfur_dioxide',
        'H2S' => 'hydrogen_sulfide',
        'PM1' => 'dust_PM1',
        'PM25' => 'dust_PM2_5',
        'PM10' => 'dust_PM10',
    ];

    /**
     * The list of first report values description mapping to their corresponding split values position.
     */
    protected const FIRST_REPORT_VALUES_DESCRIPTION = [
        'A' => 'ID станції',
        'B' => 'Температура',
        'C' => 'Тиск',
        'D' => 'Вологість',
        'E' => 'Рівень вуглекислого газу CO',
        'F' => 'Рувень NO2',
        'G' => 'Рівень пилу pm2.5',
        'H' => 'Рівень пилу pm10',
        'I' => 'Рівень пилу pm1',
        'J' => 'Рівень SO2',
        'K' => 'Рівень H2S',
        'L' => 'Максимальна швидкість вітру',
        'M' => 'Інтенсивність дощу',
        'N' => 'Напрямок вітру',
        'O' => 'Швидкість вітру',
        'P' => 'Кількість опадів',
        'Q' => 'Час вимірювання',
    ];

    /**
     *
     */
    protected const SECOND_REPORT_VALUES = [
        'nitrogen_dioxide' => 'NO2',
        'sulfur_dioxide' => 'SO2',
        'carbon_oxide' => 'CO2',
        'hydrogen_sulfide' => 'H2S',
        'dust_PM10' => 'PM25',
        'dust_PM2_5' => 'PM10',
        'temperature' => 'T',
        'humidity' => 'HUM',
        'pressure' => 'P',
        'wind_direction' => 'WD',
        'wind_speed' => 'AWS',
    ];

    /**
     * Conversion rate from Pascal (PA) to millimeters of Mercury (mmHg).
     */
    protected const PA_TO_MMHG_RATE = 0.00750062;

    /**
     * The list of repository class names.
     *
     * @var array
     */
    protected array $repositoryList = [];

    protected const  TABLE_BLOCK_SECTION_NAME = 'tableBlock';

    protected const SECOND_TYPE_DAILY_REPORT_PATH = 'reports/second-type-report-examples/daily-report.example.docx';

    protected const SECOND_TYPE_PERIOD_REPORT_PATH = 'reports/second-type-report-examples/period-report.example.docx';

    protected VaisalaSplitsRepository $vaisalaSplitsRepository;

    public function __construct()
    {
        $this->setStationVaisalaRepositories();
        $this->vaisalaSplitsRepository = new VaisalaSplitsRepository();
    }

    /**
     * Generates the first type report.
     *
     * @param string $dateFrom The starting date for the report.
     * @param string $dateTo The ending date for the report.
     * @param string $sensorId The sensor identifier.
     *
     * @return TemplateProcessor|null The generated report template processor or null if there was an error.
     */
    public function makeFirstTypeReport(
        string $dateFrom,
        string $dateTo,
        string $sensorId
    ): TemplateProcessor | null {
        try {
            $reportTemplateProcessor = new TemplateProcessor(base_path(
                'reports/first-type-report-examples/first-type-report-' . $sensorId . '.example.docx'
            ));
        } catch (\Exception $e) {
            return null;
        }

        $splitData = $this->vaisalaSplitsRepository->getSplit($dateFrom, $dateTo, $sensorId);

        $reportTemplateProcessor->setValue('dateFrom', Carbon::parse($dateFrom)->toDateString());
        $reportTemplateProcessor->setValue('timeFrom', Carbon::parse($dateFrom)->format('H:i'));
        $reportTemplateProcessor->setValue('timeTo', Carbon::parse($dateTo)->format('H:i'));
        // TODO: do smth with its rounding values
        // Loop through the values needed for the first type of report.
        foreach (self::FIRST_REPORT_VALUES as $reportValue => $splitValue) {
            if ($splitValue === 'wind_direction') {
                $reportTemplateProcessor->setValue($reportValue, $this->getWindDirection($splitData[$splitValue]));
            } elseif ($splitValue === 'pressure') {
                //convert pressure from Pa to mm Hg
                $reportTemplateProcessor->setValue($reportValue, round($splitData[$splitValue] * self::PA_TO_MMHG_RATE));
            } elseif (str_contains($splitValue, 'PM')) {
                //convert µg/m³ to mg/m³ for PM dust
                $reportTemplateProcessor->setValue($reportValue, round($splitData[$splitValue] / 1000, 2));
            } elseif ($splitValue === 'humidity') {
                $reportTemplateProcessor->setValue($reportValue, round($splitData[$splitValue] , 2));
            } elseif ($splitValue === 'wind_speed') {
                $reportTemplateProcessor->setValue($reportValue, round($splitData[$splitValue] , 2));
            } else {
                $reportTemplateProcessor->setValue($reportValue, $splitData[$splitValue]);
            }
        }

        return $reportTemplateProcessor;
    }
    //TODO: make time validation
    //TODO: return type
    public function makeSecondTypeDailyReport(string $dateFrom, string $dateEnd, string $sensorId)
    {
        try {
            $reportTemplateProcessor = new FreshAirTemplateProcessor(base_path(self::SECOND_TYPE_DAILY_REPORT_PATH));
        } catch (\Exception $e) {
            return null;
        }

//        $reportTemplateProcessor->cloneTableBlock(
//            self::TABLE_BLOCK_SECTION_NAME,
//            Carbon::parse($dateFrom)->diffInDays(Carbon::parse($dateEnd)),
//            true,
//            true
//        );

        $firstDaySplitData = $this->vaisalaSplitsRepository->getSplits(
            $dateFrom,
            $dateEnd,
            $sensorId
        );

        foreach ($firstDaySplitData as $key => $split) {
            foreach (self::SECOND_REPORT_VALUES as $splitName => $reportName) {
                $reportTemplateProcessor->setValue(
                    $reportName .'-' .$key .'-1',
                    $split[$splitName]
                );
            }
        }

        //filling first table with MAX values
        $firstDayMaxValues = $this->vaisalaSplitsRepository->getMaxValues(
            $dateFrom,
            Carbon::parse($dateFrom)->addDay(),
            $sensorId
        );

        foreach (self::SECOND_REPORT_VALUES as $splitName => $reportName) {
            $reportTemplateProcessor->setValue(
                $reportName .'-MAX-1',
                $firstDayMaxValues['max_' . $splitName]
            );
        }

        $firstDayMaxValues = $this->vaisalaSplitsRepository->getAVGValues(
            $dateFrom,
            Carbon::parse($dateFrom)->addDay(),
            $sensorId
        );

        foreach (self::SECOND_REPORT_VALUES as $splitName => $reportName) {
            $reportTemplateProcessor->setValue(
                $reportName .'-AVG-1',
                $firstDayMaxValues['avg_' . $splitName]
            );
        }

        $reportTemplateProcessor->saveAs('test-second-report.docx');
    }

    //TODO: make time validation
    //TODO: return type
    public function makeSecondTypePeriodReport(string $dateFrom, string $dateEnd, string $sensorId)
    {
        try {
            $reportTemplateProcessor = new FreshAirTemplateProcessor(base_path(self::SECOND_TYPE_PERIOD_REPORT_PATH));
        } catch (\Exception $e) {
            return null;
        }

        $dateFrom = Carbon::parse($dateFrom);
        $dateEnd = Carbon::parse($dateEnd);

        //cloning tables if the gap between days more than 2
        if ($dateFrom->diffInDays($dateEnd) > 2) {
            dump($dateFrom->diffInDays($dateEnd) - 2);
            $reportTemplateProcessor->cloneTableBlock(
                self::TABLE_BLOCK_SECTION_NAME,
                $dateFrom->diffInDays($dateEnd) - 1,
                true,
                true
            );
        }

        //filling table but not the last
        for ($i = 0; $i < $dateFrom->diffInDays($dateEnd) - 1; $i++) {
            //filling split data
            $firstDaySplitData = $this->vaisalaSplitsRepository->getSplits(
                $dateFrom->copy()->addDays($i),
                $dateEnd->copy()->addDays($i + 1),
                $sensorId
            );

//            $timestampToFind = '2022-04-06 06:00:00';
//            $foundElement = collect($firstDaySplitData)->first(function ($item) use ($timestampToFind) {
//                return $item['timestamp_start'] === $timestampToFind;
//            });
            $y = 0;
            foreach ($firstDaySplitData as $key => $split) {
                $recordTime = Carbon::parse($split['timestamp_end']);
//                dump($recordTime->format('Y-m-d H:i:s'), $recordTime->minute);
                //necessary for making report based on 00-20, 20-40 intervals
                if ($recordTime->minute === 0) {
                    //dump($split);
                    continue;
                }
                $recordIndex = $recordTime->hour * 2 + $recordTime->minute / 20 - 1;

                if ($recordIndex === $y) {
                    foreach (self::SECOND_REPORT_VALUES as $splitName => $reportName) {
                        $reportTemplateProcessor->setValue(
                            $reportName . '-' . $recordIndex . '-1' . '#' . ($i + 1),
                            $split[$splitName]
                        );

                    }
                }
                $y++;
            }

            //filling first table with MAX values
            $firstDayMaxValues = $this->vaisalaSplitsRepository->getMaxValues(
                $dateFrom->copy()->addDays($i),
                $dateEnd->copy()->addDays($i + 1),
                $sensorId
            );

            foreach (self::SECOND_REPORT_VALUES as $splitName => $reportName) {
                $reportTemplateProcessor->setValue(
                    $reportName .'-MAX-1'. '#' . ($i + 1),
                    round($firstDayMaxValues['max_' . $splitName], 3)
                );
            }

            //filling first table with AVG values
            $firstDayMaxValues = $this->vaisalaSplitsRepository->getAVGValues(
                $dateFrom->copy()->addDays($i),
                $dateEnd->copy()->addDays($i + 1),
                $sensorId
            );

            foreach (self::SECOND_REPORT_VALUES as $splitName => $reportName) {
                $reportTemplateProcessor->setValue(
                    $reportName .'-AVG-1'. '#' . ($i + 1),
                    round($firstDayMaxValues['avg_' . $splitName], 3)
                );
            }
        }

        $reportTemplateProcessor->saveAs('test-second-report.docx');
    }

    /**
     * Generates an XLSX report.
     *
     * @param string $dataFrom The starting date for the report.
     * @param string $dateTo The ending date for the report.
     *
     * @return Spreadsheet|null The generated spreadsheet or null if there was an error.
     */
    public function makeXLSXReport(string $dataFrom, string $dateTo): Spreadsheet | null
    {
        $objPHPExcel = new Spreadsheet();
        $sheet = $objPHPExcel->getActiveSheet();
        // TODO: rename
        $sheet->setTitle('report');

        $i = 2;
        foreach ($this->repositoryList as $repository) {
            $repositoryClass = new $repository();
            $stationData = $repositoryClass->getRecordsByTime($dataFrom, $dateTo);
            $stationId = $repositoryClass->getVaisalaStationId();
            foreach (self::FIRST_REPORT_VALUES_DESCRIPTION as $key => $description) {
                $sheet->setCellValue($key . 1, $description);
            }
            foreach ($stationData as $record) {
                $sheet->setCellValue('A' . $i, $stationId);
                $sheet->setCellValue('B' . $i, $record['humidity']);
                $sheet->setCellValue('C' . $i, $record['temperature']);
                $sheet->setCellValue('D' . $i, $record['pressure']);
                $sheet->setCellValue('E' . $i, $record['carbon_oxide']);
                $sheet->setCellValue('F' . $i, $record['nitrogen_dioxide']);
                $sheet->setCellValue('G' . $i, $record['dust_PM2_5']);
                $sheet->setCellValue('H' . $i, $record['dust_PM10']);
                $sheet->setCellValue('I' . $i, $record['dust_PM1']);
                $sheet->setCellValue('J' . $i, $record['sulfur_dioxide']);
                $sheet->setCellValue('K' . $i, $record['hydrogen_sulfide']);
                $sheet->setCellValue('L' . $i, $record['max_wind_speed']);
                $sheet->setCellValue('M' . $i, $record['rain_intensity']);
                $sheet->setCellValue('N' . $i, $record['wind_direction']);
                $sheet->setCellValue('O' . $i, $record['wind_speed']);
                $sheet->setCellValue('P' . $i, $record['rain_accumulation']);
                $sheet->setCellValue('Q' . $i, $record['measurement_time']);
                $i++;
            }
        }

        return $objPHPExcel;
    }

    /**
     * Converts wind direction in degrees to a human-readable format.
     *
     * @param float $degrees The wind direction in degrees.
     *
     * @return string The wind direction as a human-readable string.
     */
    public function getWindDirection(float $degrees): string
    {
        if ($degrees === null) {
            return "";
        }

        if ($degrees === 0) {
            return "Немає даних";
        }

        $directions = [
            "Пн", "ПнСх", "Сх", "ПдСх", "Пд", "ПдЗх", "Зх", "ПнЗх",
        ];

        return $directions[round(($degrees % 360) / 45)];
    }

    /**
     * Sets the list of station repository class names based on configuration.
     */
    protected function setStationVaisalaRepositories(): void
    {
        $stations = config('locations.Ua171.stations');
        $stationRepositoryList = [];

        foreach (((array) $stations ?? []) as $station) {
            if ($station['is_vaisala'] ?? false) {
                $stationRepositoryList[] = 'App\Repositories\Stations\StationsWithRawData\StationsVaisala\Station' . $station['id'] . 'Repository';
            }
        }

        $this->repositoryList = $stationRepositoryList;
    }

    //    public function convertPPMToMgPerSqM(float $ppm, string $element, float $temperature, float $pressure):float
    //    {
    //
    //    }
    //
    //    public function getMolecularMass(string $element):int
    //    {
    //        return match ($element) {
    //            'carbon_oxide' => 'Humidity',
    //            'nitrogen_dioxide' => 'Temperature',
    //            'sulfur_dioxide' => 'Pressure',
    //            'ammonia' =>
    //            'ozone' =>
    //            'hydrogen_sulfide' =>
    //            'NH₃' => 'NH3',
    //            'NO₂'=> 'NO2',
    //            'CL₂' => 'CL2',
    //            'O₃' => 'O3',
    //            default => $option,
    //        };
    //    }
}
