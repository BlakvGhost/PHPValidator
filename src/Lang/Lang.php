<?php

/**
 * Lang - This class provides a convenient mapping of rules errors messages for different languages.
 *
 * @package BlakvGhost\PHPValidator\Lang
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Lang;

trait Lang
{
    /**
     * Translations for different languages.
     *
     * @var array
     */
    private static $translations = [
        'fr' => [
            // French translations
            'validation.empty_data' => 'Les données de validation ne peuvent pas être vides.',
            'validation.empty_rules' => 'Les règles de validation ne peuvent pas être vides.',
            'validation.rule_not_found' => "La règle de validation ':ruleName' n'existe pas.",
            'validation.string_rule' => "Le champ :attribute doit être une chaîne de caractères.",
            'validation.required_rule' => "Le champ :attribute est requis.",
            'validation.required_with' => "Le champ :attribute est requis avec le champ :value.",
            'validation.not_required_with' => "Le champ :attribute n'est pas requis avec le champ :value.",
            'validation.max_length_rule' => "Le champ :attribute ne doit pas dépasser :max caractères.",
            'validation.min_length_rule' => "Le champ :attribute doit dépasser :min caractères.",
            'validation.email_rule' => "Le champ :attribute doit être un e-mail valide.",
            'validation.accepted' => "Le champ :attribute doit être accepté.",
            'validation.accepted_if' => "Le champ :attribute doit être accepté uniquement si :other existe et vrai.",
            'validation.same_rule' => "Le champ :attribute doit être identique au champ :otherAttribute.",
            'validation.password_rule' => "Le champ :attribute doit répondre aux critères de mot de passe.",
            'validation.numeric_rule' => "Le champ :attribute doit être numérique.",
            'validation.alpha_numeric' => "Le champ :attribute doit être alpha numérique.",
            'validation.nullable_rule' => "Le champ :attribute peut être nul.",
            'validation.in_rule' => "Le champ :attribute doit être l'une des valeurs suivantes :values.",
            'validation.not_in_rule' => "Le champ :attribute ne doit pas être l'une des valeurs suivantes :values.",
            'validation.confirmed_rule' => "Le champ :attribute doit être confirmé par le champ :confirmedAttribute.",
            'validation.active_url' => "Le champ :attribute doit être une URL active.",
            'validation.lowercase_rule' => "Le champ :attribute doit être en minuscules.",
            'validation.uppercase_rule' => "Le champ :attribute doit être en majuscules.",
            'validation.file_rule' => "Le champ :attribute doit être un fichier.",
            'validation.boolean' => "Le champ :attribute doit être un booléen.",
            'validation.json' => "Le champ :attribute doit être un json valide.",
            'validation.url' => "Le champ :attribute doit être un url valide.",
            'validation.valid_ip' => "Le champ :attribute doit être une addresse ip valide.",
            'validation.size' => "Le champ :attribute doit avoir la longeur réquise :value.",
        ],
        'en' => [
            // English translations
            'validation.empty_data' => 'Validation data cannot be empty.',
            'validation.empty_rules' => 'Validation rules cannot be empty.',
            'validation.rule_not_found' => "Validation rule ':ruleName' not found.",
            'validation.string_rule' => "The :attribute field must be a string.",
            'validation.required_rule' => "The :attribute field is required.",
            'validation.required_with' => "The :attribute field is required along with the :value field.",
            'validation.not_required_with' => "The :attribute field is not required along with the :value field.",
            'validation.max_length_rule' => "The :attribute field must not exceed :max characters.",
            'validation.min_length_rule' => "The :attribute field must exceed :min characters.",
            'validation.email_rule' => "The :attribute field must be a valid email.",
            'validation.accepted' => "The :attribute field must be accepted.",
            'validation.accepted_if' => "The :attribute field must be accepted if :other.",
            'validation.same_rule' => "The :attribute field must be identical to the :otherAttribute field.",
            'validation.password_rule' => "The :attribute field must meet password requirements.",
            'validation.numeric_rule' => "The :attribute field must be numeric.",
            'validation.alpha_numeric' => "The :attribute field must be alphanumeric.",
            'validation.nullable_rule' => "The :attribute field can be null.",
            'validation.in_rule' => "The :attribute field must be one of the following values: :values.",
            'validation.not_in_rule' => "The :attribute field must not be one of the following :values.",
            'validation.confirmed_rule' => "The :attribute field must be confirmed by the :confirmedAttribute field.",
            'validation.active_url' => "The :attribute field must be an active URL.",
            'validation.lowercase_rule' => "The :attribute field must be lowercase.",
            'validation.uppercase_rule' => "The :attribute field must be uppercase.",
            'validation.file_rule' => "The :attribute field must be a file.",
            'validation.boolean' => "The :attribute field must be a boolean.",
            'validation.json' => "The :attribute field must be a valid json.",
            'validation.url' => "The :attribute field must be a valid url.",
            'validation.valid_ip' => "The :attribute field must be a valid IP address.",
            'validation.size' => "The :attribute field must have the required length :value.",
        ],
    ];
}
