<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRailwayProviderRequest extends FormRequest
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
            'valid_from' => 'required|date',
            'name' => 'required|string|max:25',
        ];
    }

    public function messages(): array
    {
        return [
            'valid_from.required' => '入力内容の適用を開始する日時が指定されていません',
            'valid_from.date' => '入力内容の適用を開始する日時が不正です',
            'name.required' => '鉄道会社名を入力してください',
            'name.max' => '鉄道会社名が長すぎです',
        ];
    }
}
