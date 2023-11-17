<?php

/**
 * AlphaRule - A validation rule implementation for checking if a value contains only alphabetic characters.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\LangManager;

class AlphaRule implements RuleInterface
{
    /**
     * Name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the AlphaRule class.
     *
     * @param array $parameters No specific parameters needed for this rule.
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the value contains only alphabetic characters.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the value contains only alphabetic characters, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        // Check if the value is a string and contains only alphabetic characters.
        return is_string($value) && ctype_alpha($value);
    }

    /**
     * Get the validation error message for the alpha rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.alpha_rule', [
            'attribute' => $this->field,
        ]);
    }
}
