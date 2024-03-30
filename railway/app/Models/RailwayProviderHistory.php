<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayProviderHistory extends Model
{
    use HasFactory;

    protected $table = 'railway_provider_histories';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_provider_id',
    ];

    protected $casts = [
        'railway_provider_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';
}
