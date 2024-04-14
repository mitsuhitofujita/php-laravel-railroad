<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RailwayLineEditRequest extends FormRequest
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
            'railway_line_id' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'railway_line_id.required' => '鉄道路線IDが指定されていません',
            'railway_line_id.integer' => '鉄道路線IDが不正です',
            'railway_line_id.min' => '鉄道路線IDが不正です',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'railway_line_id' => $this->route('railway_line_id'),
        ]);
    }
}
