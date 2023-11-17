<?php

/**
 * AcceptedRule - A validation rule implementation for checking if a value is considered "accepted".
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\LangManager;

class AcceptedRule implements RuleInterface
{
    /**
     * The name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the AcceptedRule class.
     *
     * @param array $parameters Parameters for the rule (none needed for this rule).
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the given value is considered "accepted".
     *
     * @param string $field The name of the field being validated.
     * @param mixed $value The value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the value is considered "accepted", false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        // Check if the value is "1", "true", "on", or "yes".
        return in_array(strtolower($value), ['1', 'true', 'on', 'yes'], true);
    }

    /**
     * Get the validation error message for the accepted rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.accepted', [
            'attribute' => $this->field,
        ]);
    }
}
