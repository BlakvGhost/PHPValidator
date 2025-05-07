<?php

/**
 * InRule - A validation rule implementation for checking if a value is present in a given list of values.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://username-blakvghost.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\Lang\LangManager;

class InRule implements Rule
{
    /**
     * Name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the InRule class.
     *
     * @param array $parameters Parameters for the rule, specifying the list of valid values.
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the value is present in the given list of valid values.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the value is in the list of valid values, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        // Check if the value is in the list of valid values.
        return in_array($value, $this->parameters);
    }

    /**
     * Get the validation error message for the "in" rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.in_rule', [
            'attribute' => $this->field,
            'values' => implode(',', $this->parameters),
        ]);
    }
}
