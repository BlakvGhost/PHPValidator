<?php

/**
 * LangManager - A simple language manager for handling translations in the PHPValidator package.
 *
 * @package BlakvGhost\PHPValidator
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator;

class LangManager
{
    /**
     * Translations for different languages.
     *
     * @var array
     */
    protected static $translations = [
        'fr' => [
            // French translations
            'validation.empty_data' => 'Les données de validation ne peuvent pas être vides.',
            'validation.empty_rules' => 'Les règles de validation ne peuvent pas être vides.',
            'validation.rule_not_found' => "La règle de validation ':ruleName' n'existe pas.",
            'validation.string_rule' => "Le champ :attribute doit être une chaîne de caractères.",
            'validation.required_rule' => "Le champ :attribute est requis.",
            'validation.max_length_rule' => "Le champ :attribute ne doit pas dépasser :max caractères.",
            'validation.min_length_rule' => "Le champ :attribute doit dépasser :min caractères.",
            'validation.email_rule' => "Le champ :attribute doit être un e-mail.",
            'validation.accepted' => "Le champ :attribute doit être accepté.",
            'validation.same_rule' => "Le champ :attribute doit être identique au champ :otherAttribute.",
            'validation.password_rule' => "Le champ :attribute doit répondre aux critères de mot de passe.",
            'validation.numeric_rule' => "Le champ :attribute doit être numérique.",
            'validation.nullable_rule' => "Le champ :attribute peut être nul.",
            'validation.in_rule' => "Le champ :attribute doit être l'une des valeurs suivantes :values.",
            'validation.confirmed_rule' => "Le champ :attribute doit être confirmé par le champ :confirmedAttribute.",
            'validation.active_url' => "Le champ :attribute doit être une URL active.",
            'validation.lowercase_rule' => "Le champ :attribute doit être en minuscules.",
            'validation.uppercase_rule' => "Le champ :attribute doit être en majuscules.",
            'validation.file_rule' => "Le champ :attribute doit être un fichier.",
        ],
        'en' => [
            // English translations
            'validation.empty_data' => 'Validation data cannot be empty.',
            'validation.empty_rules' => 'Validation rules cannot be empty.',
            'validation.rule_not_found' => "Validation rule ':ruleName' not found.",
            'validation.string_rule' => "The :attribute field must be a string.",
            'validation.required_rule' => "The :attribute field is required.",
            'validation.max_length_rule' => "The :attribute field must not exceed :max characters.",
            'validation.min_length_rule' => "The :attribute field must exceed :min characters.",
            'validation.email_rule' => "The :attribute field must be an email.",
            'validation.accepted' => "The :attribute field must be accepted.",
            'validation.same_rule' => "The :attribute field must be identical to the :otherAttribute field.",
            'validation.password_rule' => "The :attribute field must meet password requirements.",
            'validation.numeric_rule' => "The :attribute field must be numeric.",
            'validation.nullable_rule' => "The :attribute field can be null.",
            'validation.in_rule' => "The :attribute field must be one of the following values: :values.",
            'validation.confirmed_rule' => "The :attribute field must be confirmed by the :confirmedAttribute field.",
            'validation.active_url' => "The :attribute field must be an active URL.",
            'validation.lowercase_rule' => "The :attribute field must be lowercase.",
            'validation.uppercase_rule' => "The :attribute field must be uppercase.",
            'validation.file_rule' => "The :attribute field must be a file.",
        ],
    ];


    /**
     * Get the current language.
     *
     * @return string Current language code.
     */
    private static function getLocal(): string
    {
        // Get the current language from environment variables, defaulting to 'en' (English) if not set.
        return $_ENV['local'] ?? 'en';
    }

    /**
     * Get a translated message for the given key.
     *
     * @param string $key Translation key.
     * @param array|null $parameters Placeholder values to replace in the translated message.
     * @return string Translated message.
     */
    public static function getTranslation(string $key, ?array $parameters = []): string
    {
        // Get the translation for the current language and the provided key, or use the key itself if not found.
        $translation = self::$translations[self::getLocal()][$key] ?? $key;

        // Replace placeholders in the translation with the provided values.
        if ($parameters) {
            foreach ($parameters as $placeholder => $value) {
                $translation = str_replace(":$placeholder", $value, $translation);
            }
        }

        return $translation;
    }
}
