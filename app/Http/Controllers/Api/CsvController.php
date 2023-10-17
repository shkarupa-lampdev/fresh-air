<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\UploadCSVService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CsvController extends BaseController
{
    protected UploadCSVService $uploadCSVService;

    public function __construct(UploadCSVService $uploadCSVService)
    {
        $this->uploadCSVService = $uploadCSVService;
    }

    public function uploadCsv(Request $request): JsonResponse
    {
        if (!$request->hasFile('file')) {
            return $this->sendError('Файл не знайдений');
        }

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if ($extension !== 'csv') {
            return $this->sendError('Файл має містити розширення .csv');
        }

        $response = $this->uploadCSVService->uploadCSV($request);

        if (!empty($response['error'])) {
            return $this->sendError($response['error']);
        }
        return $this->sendResponse($response['message']);
    }
}
