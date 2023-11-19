<?php

/**
 * SameRule - A validation rule implementation for checking if a field's value is the same as another field's value.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\LangManager;

class SameRule implements Rule
{
    /**
     * Name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the SameRule class.
     *
     * @param array $parameters Parameters for the rule, specifying the other field name to compare.
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the field's value is the same as another field's value.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the field's value is the same as the other field's value, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        // Check if the other field is present and its value matches the field's value.
        return isset($data[$this->parameters[0]]) && $value === $data[$this->parameters[0]];
    }

    /**
     * Get the validation error message for the same rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.same_rule', [
            'attribute' => $this->field,
            'otherAttribute' => $this->parameters[0] ?? '',
        ]);
    }
}
