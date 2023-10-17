<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ChartDailyRequest;
use App\Repositories\Stations\VaisalaSplitsRepository;
use App\Services\SplitServices\SplitBaseService;
use Illuminate\Http\JsonResponse;

class ChartController extends BaseController
{
    protected SplitBaseService $splitBaseService;
    protected VaisalaSplitsRepository $vaisalaSplitsRepository;

    public function __construct(
        SplitBaseService $splitBaseService = new SplitBaseService(),
        VaisalaSplitsRepository $vaisalaSplitsRepository = new VaisalaSplitsRepository()
    ) {
        $this->splitBaseService = $splitBaseService;
        $this->vaisalaSplitsRepository = $vaisalaSplitsRepository;
    }

    /**
     * Charts api.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get20mSplit(string $city, string $timeStart, string $timeEnd): JsonResponse
    {
        $locationRepository = $this->splitBaseService->getLocationService($city)->getRepository();

        return $this->sendResponse('', ['chart' => $locationRepository->getSplit20mData($timeStart, $timeEnd)]);
    }

    //    public function getDailySplit(ChartDailyRequest $request): JsonResponse
    //    {
    //        return $this->sendResponse('', ['chart' =>$this->splitMeasurementRepository->getSplitDailyData($request->timeStart, $request->timeEnd)]);
    //    }
    //
    public function getSplit20mRange(string $city): JsonResponse
    {
        $locationRepository = $this->splitBaseService->getLocationService($city)->getRepository();

        return $this->sendResponse('', [
            'first' => $locationRepository->getFirst20mTime(),
            'last' => $locationRepository->getLast20mTime(),
        ]);
    }
    //
    //    public function getSplitDailyRange(): JsonResponse
    //    {
    //        return $this->sendResponse('', ['last' => $this->splitMeasurementRepository->getLastDayTimeEcoCity(),
    //            'first' => $this->splitMeasurementRepository->getFirstDayTimeEcoCity()]);
    //    }
}
