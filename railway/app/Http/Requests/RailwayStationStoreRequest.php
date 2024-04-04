<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RailwayStationStoreRequest extends FormRequest
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
        return [
            'railway_route_id' => 'required|integer|min:1',
            'valid_from' => 'required|date',
            'name' => 'required|max:25',
            'nickname' => 'nullable|max:25',
        ];
    }

    public function messages(): array
    {
        return [
            'railway_route_id.required' => '鉄道路線IDが指定されていません',
            'railway_route_id.integer' => '鉄道路線IDが不正ですint',
            'railway_route_id.min' => '鉄道路線IDが不正ですmin',
            'valid_from.required' => '入力内容の適用を開始する日時が指定されていません',
            'valid_from.date' => '入力内容の適用を開始する日時が不正です',
            'name.required' => '鉄道駅名を入力してください',
            'name.max' => '鉄道駅名が長すぎです',
            'nickname.max' => '鉄道駅愛称が長すぎです',
        ];
    }
}
