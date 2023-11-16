<?php

namespace BlakvGhost\PHPValidator;

class LangManager
{
    protected static $translations = [
        'fr' => [
            'validation.empty_data' => 'Les données de validation ne peuvent pas être vides.',
            'validation.empty_rules' => 'Les règles de validation ne peuvent pas être vides.',
        ],
        'en' => [
            'validation.empty_data' => 'Validation data cannot be empty.',
            'validation.empty_rules' => 'Validation rules cannot be empty.',
        ],
    ];

    private function getLocal(): string
    {
        return $_ENV['local'] ?? 'en';
    }

    public static function getTranslation(string $key): string
    {
        return self::$translations[self::getLocal()][$key] ?? $key;
    }
}
