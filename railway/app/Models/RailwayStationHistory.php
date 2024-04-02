<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayStationHistory extends Model
{
    use HasFactory;

    protected $table = 'railway_station_histories';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_station_id',
    ];

    protected $casts = [
        'railway_station_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';
}
