<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station1748 extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'station1748';
    protected $fillable = [
        'place_id',
        'measurement_time',
        'split_number',
        'measurement_ratio',
        'option',
        'measurement_unit',
        'measurement_value',
        'unique_hash',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->unique_hash = md5(
                $model->place_id
                . $model->split_number
                . $model->option
                . $model->measurement_value
                . $model->measurement_time
            );
        });
    }
}
