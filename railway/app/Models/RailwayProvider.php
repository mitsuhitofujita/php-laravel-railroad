<?php

namespace App\Models;

use App\Events\RailwayProviderCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RailwayProvider extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'railway_providers';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_provider_event_stream_id',
    ];

    protected $casts = [
        'railway_provider_event_stream_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => RailwayProviderCreated::class,
    ];
}
