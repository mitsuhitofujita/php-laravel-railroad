<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRailwayRouteRequest extends FormRequest
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
            'railwayRouteId' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'railwayRouteId.required' => '鉄道路線IDが指定されていません',
            'railwayRouteId.integer' => '鉄道路線IDが不正です',
            'railwayRouteId.min' => '鉄道路線IDが不正です',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'railwayRouteId' => $this->route('railwayRouteId'),
        ]);
    }
}
