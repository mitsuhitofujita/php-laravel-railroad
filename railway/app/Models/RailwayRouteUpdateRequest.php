<?php

namespace App\Models;

use App\Events\RailwayRouteUpdateRequestCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RailwayRouteUpdateRequest extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'railway_route_update_requests';

    const UPDATED_AT = null;

    protected $fillable = [
        'token',
        'railway_route_event_stream_id',
        'railway_route_id',
        'railway_provider_id',
        'valid_from',
        'name',
    ];

    protected $casts = [
        'token' => 'string',
        'railway_route_event_stream_id' => 'integer',
        'railway_route_id' => 'integer',
        'railway_provider_id' => 'integer',
        'valid_from' => 'datetime',
        'name' => 'string',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dispatchesEvents = [
        'created' => RailwayRouteUpdateRequestCreated::class,
    ];

    public static function existsToken(string $token): bool
    {
        return self::query()
            ->where('token', '=', $token)
            ->exists();
    }
}
