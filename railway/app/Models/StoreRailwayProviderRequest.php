<?php

namespace App\Models;

use App\Events\StoreRailwayProviderRequestCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class StoreRailwayProviderRequest extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'store_railway_provider_requests';

    const UPDATED_AT = null;

    protected $fillable = [
        'token',
        'railway_provider_event_stream_id',
        'name',
    ];

    protected $casts = [
        'railway_provider_event_stream_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => StoreRailwayProviderRequestCreated::class,
    ];

    public static function existsToken(string $token): bool
    {
        return self::query()
            ->where('token', '=', $token)
            ->exists();
    }
}
