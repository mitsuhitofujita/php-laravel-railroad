<?php

namespace App\Http\Validations;

class GenericNameValidation
{
    public static function rules(string $key): array {
        return [
            $key => 'required|max:25',
        ];
    }

    public static function messages(string $key, string $name): array {
        return [
            "{$key}.required" => "{$name}を入力してください",
            "{$key}.max" => "{$name}が長すぎです",
        ];
    }
}
