<?php

/**
 * NotNullableRule - A validation rule implementation for checking if a field's value is not null.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabiroualassane.link
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\Lang\LangManager;

class NotNullableRule implements Rule
{
    /**
     * Name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the NotNullableRule class.
     *
     * @param array $parameters Parameters for the rule, not used in this rule.
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if a field's value is not null.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the field's value is not null, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Store field name for message replacement
        $this->field = $field;

        if (!$value || $value === null || (is_string($value) && trim($value) === '')) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message for the not-nullable rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.not_nullable_rule', [
            'attribute' => $this->field,
        ]);
    }
}
