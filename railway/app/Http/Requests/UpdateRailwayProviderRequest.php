<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRailwayProviderRequest extends FormRequest
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
            'railway_provider_id' => 'required|integer|min:1',
            'valid_from' => 'required|date',
            'name' => 'required|string|max:25',
        ];
    }

    public function messages(): array
    {
        return [
            'railway_provider_id.required' => '鉄道会社IDが指定されていません',
            'railway_provider_id.integer' => '鉄道会社IDが不正です',
            'railway_provider_id.min' => '鉄道会社IDが不正です',
            'valid_from.required' => '入力内容の適用を開始する日時が指定されていません',
            'valid_from.date' => '入力内容の適用を開始する日時が不正です',
            'name.required' => '鉄道会社名を入力してください',
            'name.max' => '鉄道会社名が長すぎです',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['railway_provider_id' => $this->route('railway_provider_id')]);
    }

}
