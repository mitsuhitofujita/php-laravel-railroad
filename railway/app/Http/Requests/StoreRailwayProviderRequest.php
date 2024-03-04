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
            'name' => 'required|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '鉄道会社名を入力してください',
            'name.max' => '鉄道会社名が長すぎです',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge(['action' => 'create']);
    }
}
