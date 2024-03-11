<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayProviderDetail extends Model
{
    use HasFactory;

    protected $table = 'railway_provider_details';

    const UPDATED_AT = null;

    protected $fillable = [
        'railway_provider_id',
        'name',
    ];

    protected $casts = [
        'railway_provider_id' => 'integer',
        'created_at' => 'datetime',
    ];
}
