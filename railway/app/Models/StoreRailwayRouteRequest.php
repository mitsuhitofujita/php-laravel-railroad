<?php

namespace App\Models;

use App\Events\StoreRailwayRouteRequestCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class StoreRailwayRouteRequest extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'store_railway_route_requests';

    const UPDATED_AT = null;

    protected $fillable = [
        'token',
        'railway_route_event_stream_id',
        'railway_provider_id',
        'name',
    ];

    protected $casts = [
        'railway_provider_event_stream_id' => 'integer',
        'railway_provider_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => StoreRailwayRouteRequestCreated::class,
    ];

    public static function existsToken(string $token): bool
    {
        return self::query()
            ->where('token', '=', $token)
            ->exists();
    }
}
