<?php

namespace App\Models;

use App\Events\RailwayRouteCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RailwayRoute extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'railway_routes';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_route_event_stream_id',
    ];

    protected $casts = [
        'railway_route_event_stream_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => RailwayRouteCreated::class,
    ];
}
