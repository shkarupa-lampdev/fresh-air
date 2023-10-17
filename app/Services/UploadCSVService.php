<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class EcoCityService.
 *
 * This class provides methods for uploading and processing EcoCity data from CSV files.
 */
class UploadCSVService
{
    private CsvValidatorService $validator;

    public function __construct()
    {
        $this->validator = new CsvValidatorService();
    }

    /**
     * Upload and process CSV file from command line.
     *
     * @param string $filePath the path of the CSV file to upload
     *
     * @return void
     */
    public function uploadCSVFromCommand(string $filePath): void
    {
        try {
            $csvFileHandler = fopen($filePath, 'r');
            $this->uploadEcoCityData($csvFileHandler);

            echo 'CSV-файл успішно завантажений та обробленый.';
        } catch (\Exception $e) {
        }
    }

    /**
     * Upload and process CSV file from HTTP request.
     *
     * @param Request $request the HTTP request containing the CSV file
     *
     * @return array an associative array with a 'success' key or a message with key 'error'
     */
    public function uploadCSV(Request $request): array
    {
        try {
            $csfFile = $request->file('file');
            $csvFileHandler = fopen($csfFile->getRealPath(), 'r');
            $this->uploadEcoCityData($csvFileHandler);

            return ['message' => 'CSV-файл успішно завантажений та обробленый.'];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Upload and process EcoCity data from a CSV file.
     *
     * @param resource $csvFileHandler the file handler of the CSV file
     */
    public function uploadEcoCityData($csvFileHandler): void
    {
        while (!feof($csvFileHandler)) {
            $measurementData = str_getcsv(trim(fgets($csvFileHandler)));

            try {
                if (!$this->validator->validateRecord($measurementData)) {
                    continue;
                }
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'error' => $e,
                ]);
            }

            try {
                $this->validator->getRepository()->create($measurementData);
            } catch (\Exception $e) {
                if ($e->getCode() == 23000) {
                    continue;
                }

                throw ValidationException::withMessages([
                    'error' => $e->getCode(),
                ]);
            }
        }
        fclose($csvFileHandler);
    }
}
