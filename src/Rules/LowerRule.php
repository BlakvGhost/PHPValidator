<?php

/**
 * LowercaseRule - A validation rule implementation for checking if a field's value is lowercase.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\LangManager;

class LowerRule implements RuleInterface
{
    /**
     * The name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the LowercaseRule class.
     *
     * @param array $parameters Parameters for the rule (not used in this rule).
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the field's value is lowercase.
     *
     * @param string $field The name of the field being validated.
     * @param mixed $value The value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the value is lowercase, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        // Check if the value is lowercase.
        return mb_strtolower($value, 'UTF-8') === $value;
    }

    /**
     * Get the validation error message for the lowercase rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.lowercase_rule', [
            'attribute' => $this->field,
        ]);
    }
}
