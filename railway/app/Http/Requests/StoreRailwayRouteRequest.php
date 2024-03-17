<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRailwayRouteRequest extends FormRequest
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
            'railwayProviderId' => 'required|integer|min:1',
            'name' => 'required|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'railwayProviderId.required' => '鉄道会社IDが指定されていません',
            'railwayProviderId.integer' => '鉄道会社IDが不正です',
            'railwayProviderId.min' => '鉄道会社IDが不正です',
            'name.required' => '鉄道路線名を入力してください',
            'name.max' => '鉄道路線名が長すぎです',
        ];
    }
}
