<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaisalaApiLog extends Model
{
    use HasFactory;

    protected $table = 'vaisala_api_log';
    protected $fillable = [
        'station_id',
        'sensor_id',
        'status',
        'error_message',
        'date_start',
        'date_end',
    ];
}
