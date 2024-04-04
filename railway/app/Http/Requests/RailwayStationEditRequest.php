<?php

namespace App\Http\Requests;

use App\Http\Validations\RailwayStationIdValidation;
use Illuminate\Foundation\Http\FormRequest;

class RailwayStationEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return RailwayStationIdValidation::rules();
    }

    public function messages(): array
    {
        return RailwayStationIdValidation::messages();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'railway_station_id' => $this->station('railway_station_id'),
        ]);
    }
}
