<?php

namespace App\Http\Controllers;

use App\Http\Requests\FirstTypeReportRequest;
use App\Http\Requests\VaisalaStationRangeRequest;
use App\Http\Requests\XLSXReportRequest;
use App\Repositories\Stations\VaisalaSplitsRepository;
use App\Services\ReportService;
use App\Services\SplitServices\SplitBaseService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReportController extends BaseController
{
    protected SplitBaseService $splitService;
    protected VaisalaSplitsRepository $vaisalaSplitsRepository;
    protected ReportService $reportService;

    public function __construct(
        ReportService $reportService,
        SplitBaseService $splitService,
        VaisalaSplitsRepository $vaisalaSplitsRepository
    ) {
        $this->reportService = $reportService;
        $this->splitService = $splitService;
        $this->vaisalaSplitsRepository = $vaisalaSplitsRepository;
    }

    public function getVaisalaRange(VaisalaStationRangeRequest $request): JsonResponse
    {
        return $this->sendResponse('', [
            'first' => $this->vaisalaSplitsRepository->getFirst20mDate(),
            'last' => $this->vaisalaSplitsRepository->getLast20mDate(),
        ]);
    }

    public function getVaisalaSensorRange(VaisalaStationRangeRequest $request): JsonResponse
    {
        return $this->sendResponse('', [
            'first' => $this->vaisalaSplitsRepository->getFirstSensorDate($request->input('sensor')),
            'last' => $this->vaisalaSplitsRepository->getLastSensorDate($request->input('sensor')),
        ]);
    }

    public function makeFirstTypeReport(FirstTypeReportRequest $request)
    {
        $dateTo = Carbon::parse($request->input('dateFrom'));
        $dateFrom = Carbon::parse($request->input('dateFrom'));
        switch ($request->input('period')) {
            case '20m':
                $dateTo->addMinutes(20);
                break;
            case 'hour':
                $dateTo->addHour();
                break;
            case 'day':
                $dateTo->addDay();
                break;
            case 'week':
                $dateTo->addWeek();
                break;
            case 'month':
                $dateTo->addMonth();
                break;
            case 'year':
                $dateTo->addYear();
                break;
            default:
                $this->sendError('Відсутній параметр period');
        }
        $templateProcessor = $this->reportService->makeFirstTypeReport(
            $dateFrom,
            $dateTo,
            $request->input('sensor')
        );

        $tempFilePath = tempnam(sys_get_temp_dir(), 'word');

        if ($templateProcessor === null) {
            return $this->sendError('Error');
        }
        $templateProcessor->saveAs($tempFilePath);
        return response()->download($tempFilePath, 'Перетин-підприемств-північного-промвузла.docx')->deleteFileAfterSend();
    }

    public function downloadXLSXReport(XLSXReportRequest $request)
    {
        $dataFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');

        $spreadsheet = $this->reportService->makeXLSXReport($dataFrom, $dateTo);

        if ($spreadsheet === null) {
            return $this->sendError('Error');
        }

        $tempFilePath = tempnam(sys_get_temp_dir(), 'xlsx');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tempFilePath);

        return response()->download($tempFilePath, Carbon::parse($dataFrom)->format("Y:m:d")
            . '-'
            . Carbon::parse($dateTo)->format("Y:m:d")
        )->deleteFileAfterSend();
    }
}
