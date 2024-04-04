<?php

namespace App\Http\Validations;

class GenericIdValidation
{
    public static function rules(string $key): array {
        return [
            $key => 'required|integer|min:1',
        ];
    }

    public static function messages(string $key, string $name): array {
        return [
            "{$key}.required" => "{$name}IDが指定されていません",
            "{$key}.integer" => "{$name}IDが不正です",
            "{$key}.min" => "{$name}IDが不正です",
        ];
    }
}
