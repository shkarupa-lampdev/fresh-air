<?php

namespace App\Repositories;

use App\Models\VaisalaApiLog;

class VaisalaApiLogRepository
{
    public function create(array $logData): void
    {
        VaisalaApiLog::factory()->create([
            'station_id' => $logData['station_id'],
            'sensor_id' => $logData['sensor_id'],
            'status' => $logData['status'],
            'error_message' => $logData['error_message'],
            'date_start' => $logData['date_start'],
            'date_end' => $logData['date_end'],
        ]);
    }

    public function getSensorSuccessLastEndTime(string $sensor): string | null
    {
        return VaisalaApiLog::where('sensor_id', $sensor)
            ->where('status', 'success')
            ->max('date_end');
    }
}
