<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayLineHistoryDetail extends Model
{
    use HasFactory;

    protected $table = 'railway_line_history_details';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_line_history_id',
        'railway_line_detail_id',
    ];

    protected $casts = [
        'railway_line_history_id' => 'integer',
        'railway_line_detail_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';
}
