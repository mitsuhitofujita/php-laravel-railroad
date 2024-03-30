<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayRouteHistory extends Model
{
    use HasFactory;

    protected $table = 'railway_route_histories';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_route_id',
    ];

    protected $casts = [
        'railway_route_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';
}
