<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RailwayRouteEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'railway_route_id' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'railway_route_id.required' => '鉄道路線IDが指定されていません',
            'railway_route_id.integer' => '鉄道路線IDが不正です',
            'railway_route_id.min' => '鉄道路線IDが不正です',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'railway_route_id' => $this->route('railway_route_id'),
        ]);
    }
}
