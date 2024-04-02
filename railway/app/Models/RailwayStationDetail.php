<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayStationDetail extends Model
{
    use HasFactory;

    protected $table = 'railway_station_details';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_route_id',
        'valid_from',
        'name',
        'nickname',
    ];

    protected $casts = [
        'railway_route_id' => 'integer',
        'valid_from' => 'datetime',
        'name' => 'string',
        'nickname' => 'string',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';
}
