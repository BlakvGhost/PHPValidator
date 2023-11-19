<?php

/**
 * RequiredRule - A validation rule implementation for checking if a field is required and not empty.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\LangManager;

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
        // Set the field property for use in the message method.
        $this->field = $field;

        // Check if the field is set in the data and not empty.
        return isset($data[$field]) && !empty($data[$field]);
    }

    /**
     * Get the validation error message for the required rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.required_rule', [
            'attribute' => $this->field,
        ]);
    }
}
