<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayProviderDetail extends Model
{
    use HasFactory;

    protected $table = 'railway_provider_details';

    protected $fillable = [
        'railway_provider_id',
        'valid_from',
        'valid_to',
        'name',
    ];

    protected $casts = [
        'railway_provider_id' => 'integer',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
        'name' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';
}
