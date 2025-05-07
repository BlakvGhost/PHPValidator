<?php

/**
 * RequiredRule - A validation rule implementation for checking if a field is required and not empty.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://username-blakvghost.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\Lang\LangManager;

class RequiredRule implements Rule
{
    /**
     * Name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the RequiredRule class.
     *
     * @param array $parameters Parameters for the rule, if any.
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the given field is required and not empty.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the field is required and not empty, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        $this->field = $field;

        // Supporte la notation avec points, ex : 'user.name' ou 'user.*.name'
        $segments = explode('.', $field);
        $current = $data;

        foreach ($segments as $index => $segment) {
            // Si le segment contient un wildcard '*', on vérifie tous les éléments du niveau actuel.
            if ($segment === '*') {
                // Vérification des sous-champs pour tous les éléments à ce niveau
                if (is_array($current)) {
                    foreach ($current as $subItem) {
                        if (is_array($subItem) && array_key_exists($segments[$index + 1], $subItem)) {
                            return !empty($subItem[$segments[$index + 1]]);
                        }
                    }
                }
                return false; // Si aucun élément n'est trouvé, c'est invalide
            }

            if (is_array($current) && array_key_exists($segment, $current)) {
                $current = $current[$segment];
            } else {
                return false; // Segment manquant => champ requis absent
            }
        }

        // Vérifie que la valeur finale n'est pas vide
        return !empty($current);
    }

    /**
     * Get the validation error message for the required rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        return LangManager::getTranslation('validation.required_rule', [
            'attribute' => $this->field,
        ]);
    }
}
