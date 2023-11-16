<?php

namespace BlakvGhost\PHPValidator;

class LangManager
{
    protected static $translations = [
        'fr' => [
            'validation.empty_data' => 'Les données de validation ne peuvent pas être vides.',
            'validation.empty_rules' => 'Les règles de validation ne peuvent pas être vides.',
            'validation.rule_not_found' => "La règle de validation ':ruleName' n'existe pas.",
            'validation.string_rule' => "Le champ :attribute doit être une chaîne de caractères.",
            'validation.required_rule' => "Le champ :attribute est requis.",
        ],
        'en' => [
            'validation.empty_data' => 'Validation data cannot be empty.',
            'validation.empty_rules' => 'Validation rules cannot be empty.',
            'validation.rule_not_found' => "Validation rule ':ruleName' not found.",
            'validation.string_rule' => "The :attribute field must be a string.",
            'validation.required_rule' => "The :attribute field is required.",
        ],
    ];

    private static function getLocal(): string
    {
        return $_ENV['local'] ?? 'en';
    }

    public static function getTranslation(string $key, ?array $parameters = []): string
    {
        $translation = self::$translations[self::getLocal()][$key] ?? $key;

        if ($parameters) {
            foreach ($parameters as $placeholder => $value) {
                $translation = str_replace(":$placeholder", $value, $translation);
            }
        }

        return $translation;
    }
}
