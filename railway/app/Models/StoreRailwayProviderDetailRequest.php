<?php

namespace App\Models;

use App\Events\StoreRailwayProviderRequestCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class StoreRailwayProviderDetailRequest extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'store_railway_provider_detail_requests';

    const UPDATED_AT = null;

    protected $fillable = [
        'token',
        'railway_provider_event_stream_id',
        'railway_provider_id',
        'valid_from',
        'valid_to',
        'name',
    ];

    protected $casts = [
        'railway_provider_event_stream_id' => 'integer',
        'railway_provider_id' => 'integer',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
        'name' => 'string',
        'created_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        // 'created' => StoreRailwayProviderDetailRequestCreated::class,
    ];

    public static function existsToken(string $token): bool
    {
        return self::query()
            ->where('token', '=', $token)
            ->exists();
    }
}
