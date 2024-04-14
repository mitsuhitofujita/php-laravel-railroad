<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayLineHistory extends Model
{
    use HasFactory;

    protected $table = 'railway_line_histories';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_line_id',
    ];

    protected $casts = [
        'railway_line_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';
}
