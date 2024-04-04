<?php

namespace App\Models;

use App\Events\RailwayStationStoreRequestCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RailwayStationStoreRequest extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'railway_station_store_requests';

    const UPDATED_AT = null;

    protected $fillable = [
        'token',
        'railway_station_event_stream_id',
        'railway_route_id',
        'valid_from',
        'name',
        'nickname',
    ];

    protected $casts = [
        'railway_station_event_stream_id' => 'integer',
        'railway_route_id' => 'integer',
        'valid_from' => 'datetime',
        'name' => 'string',
        'nickname' => 'string',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dispatchesEvents = [
        'created' => RailwayStationStoreRequestCreated::class,
    ];

    public static function existsToken(string $token): bool
    {
        return self::query()
            ->where('token', '=', $token)
            ->exists();
    }
}
