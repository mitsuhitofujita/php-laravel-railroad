<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Support\Str;

class FormToken
{
    public static function make()
    {
        return Str::random(64);
    }
}
