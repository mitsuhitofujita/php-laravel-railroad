<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RailwayProviderRequest extends Model
{
    use HasFactory;

    protected $table = 'railway_provider_requests';

    const UPDATED_AT = null;

    protected $fillable = [
        'token',
        'action',
        'resource_uuid',
        'railway_provider_id',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'railway_provider_id' => 'integer',
    ];

    public function existsUniqueToken(): bool
    {
        return self::query()
            ->where('token', '=', $this->token)
            ->exists();
    }
}
