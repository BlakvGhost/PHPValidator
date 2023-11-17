<?php

/**
 * MinLengthRule - A validation rule implementation for checking if a string field does not exceed a mininum length.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\LangManager;

class MinLengthRule implements RuleInterface
{
    /**
     * Name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the MinLengthRule class.
     *
     * @param array $parameters Parameters for the rule, specifying the mininum length.
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the length of the given string field does not exceed the specified mininum length.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the length is within the specified mininum, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        // Get the mininum length from the parameters, defaulting to 0 if not set.
        $minLength = $this->parameters[0] ?? 0;

        // Check if the value is a string and its length is within the specified mininum.
        return is_string($value) && mb_strlen($value) >= $minLength;
    }

    /**
     * Get the validation error message for the max length rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.min_length_rule', [
            'attribute' => $this->field,
            'min' => $this->parameters[0] ?? 0,
        ]);
    }
}
