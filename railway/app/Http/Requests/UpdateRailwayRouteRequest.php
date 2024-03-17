<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRailwayRouteRequest extends FormRequest
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
            'railwayProviderId' => 'required|integer|min:1',
            'name' => 'required|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'railwayRouteId.required' => '鉄道路線IDが指定されていません',
            'railwayRouteId.integer' => '鉄道路線IDが不正です',
            'railwayRouteId.min' => '鉄道路線IDが不正です',
            'railwayProviderId.required' => '鉄道会社IDが指定されていません',
            'railwayProviderId.integer' => '鉄道会社IDが不正です',
            'railwayProviderId.min' => '鉄道会社IDが不正です',
            'name.required' => '鉄道路線名を入力してください',
            'name.max' => '鉄道路線名が長すぎです',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'railwayRouteId' => $this->route('railwayRouteId'),
        ]);
    }
}
