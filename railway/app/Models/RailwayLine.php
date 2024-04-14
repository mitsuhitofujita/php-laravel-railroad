<?php

namespace App\Models;

use App\Events\RailwayLineCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RailwayLine extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'railway_lines';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_line_event_stream_id',
    ];

    protected $casts = [
        'railway_line_event_stream_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dispatchesEvents = [
        'created' => RailwayLineCreated::class,
    ];
}
