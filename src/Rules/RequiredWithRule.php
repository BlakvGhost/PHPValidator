<?php

/**
 * RequiredWith - A validation rule implementation fthat require the field to be present if another specified field is present
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Fortunatus KIDJE (v1p3r75)
 * @github https://github.com/v1p3r75
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\Lang\LangManager;

class RequiredWithRule implements Rule
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
     * Check if the value is required with another value.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the value is required with another value, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        $otherKey = $this->parameters[0];

        return isset($value, $data[$otherKey]) && (!empty($value) && !empty($data[$otherKey]));
    }

    /**
     * Get the validation error message for this rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        return LangManager::getTranslation('validation.required_with', [
            'attribute' => $this->field,
            'value' => $this->parameters[0]
        ]);
    }
}
