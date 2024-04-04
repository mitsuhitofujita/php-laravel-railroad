<?php

namespace App\Http\Validations;

class RailwayStationIdValidation
{
    public static function rules(): array {
        return GenericIdValidation::rules('railway_station_id');
    }

    public static function messages(): array {
        return GenericIdValidation::messages('railway_station_id', '鉄道駅');
    }
}
