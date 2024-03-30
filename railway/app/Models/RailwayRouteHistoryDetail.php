<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayRouteHistoryDetail extends Model
{
    use HasFactory;

    protected $table = 'railway_route_history_details';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_route_history_id',
        'railway_route_detail_id',
    ];

    protected $casts = [
        'railway_route_history_id' => 'integer',
        'railway_route_detail_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';
}
