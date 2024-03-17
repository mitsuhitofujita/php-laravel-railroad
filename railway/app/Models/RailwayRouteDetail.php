<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayRouteDetail extends Model
{
    use HasFactory;

    protected $table = 'railway_route_details';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_route_id',
        'railway_provider_id',
        'name',
    ];

    protected $casts = [
        'railway_route_id' => 'integer',
        'railway_provider_id' => 'integer',
        'created_at' => 'datetime',
    ];
}
