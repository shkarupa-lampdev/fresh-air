<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CsvValidatorService
{
    protected string $repositoryName = '';

    protected array $validationRules = [];

    private array $stations;

    public function __construct()
    {
        $this->stations = config('csvfiles.stations');
    }

    /**
     * Validates a measurement data record using the specified validation rules.
     *
     * @param array $measurementData the measurement data record to be validated
     *
     * @throws ValidationException if the file fails all validations check
     *
     * @return bool true if the record is valid, false otherwise
     */
    public function validateRecord(array $measurementData): bool
    {
        if ($this->validationRules === []) {
            if (!$this->setValidatorStateFromRecord($measurementData)) {
                throw ValidationException::withMessages([
                    'error' => 'Файл не пройшов перевірку',
                ]);
            }
        }

        $validator = Validator::make([], $this->validationRules);

        $validator->setData($measurementData);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    /**
     * Gets the name of the repository associated with the record.
     */
    public function getRepository()
    {
        return new $this->repositoryName();
    }

    /**
     * Sets the validation rules for the record.
     *
     * @param array $rules the validation rules to be set
     */
    private function setValidationRules(array $rules): void
    {
        $this->validationRules = $rules;
    }

    /**
     * Sets the name of the repository associated with the record.
     *
     * @param string $repositoryName the name of the repository
     */
    private function setRepositoryName(string $repositoryName): void
    {
        $this->repositoryName = $repositoryName;
    }

    /**
     * Sets the state of the validator based on the provided record.
     *
     * @param array $measurementData the measurement data of the record
     *
     * @return bool true if the validator state is set successfully, false otherwise
     */
    private function setValidatorStateFromRecord(array $measurementData): bool
    {
        foreach ($this->stations as $station) {
            $validator = Validator::make([], $station['validation_rules']);

            $validator->setData($measurementData);

            if ($validator->fails()) {
                continue;
            }

            $this->setRepositoryName($station['repository']);
            $this->setValidationRules($station['validation_rules']);
            return true;
        }
        return false;
    }
}
