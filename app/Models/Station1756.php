<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station1756 extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'station1756';
    protected $fillable = [
        'place_id',
        'measurement_sensor',
        'option',
        'measurement_unit',
        'measurement_value',
        'measurement_time',
        'unique_hash',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->unique_hash = md5(
                $model->place_id
                . $model->measurement_sensor
                . $model->measurement_value
                . $model->measurement_time
            );
        });
    }
}
