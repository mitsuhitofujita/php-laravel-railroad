<?php

namespace App\Models;

use App\Events\RailwayProviderUpdateRequestCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UpdateRailwayProviderRequest extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'update_railway_provider_requests';

    const UPDATED_AT = null;

    protected $fillable = [
        'token',
        'railway_provider_event_stream_id',
        'railway_provider_id',
        'valid_from',
        'name',
    ];

    protected $casts = [
        'token' => 'string',
        'railway_provider_event_stream_id' => 'integer',
        'railway_provider_id' => 'integer',
        'valid_from' => 'datetime',
        'name' => 'string',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dispatchesEvents = [
        'created' => RailwayProviderUpdateRequestCreated::class,
    ];

    public static function existsToken(string $token): bool
    {
        return self::query()
            ->where('token', '=', $token)
            ->exists();
    }
}
