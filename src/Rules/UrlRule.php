<?php

/**
 * URLRule - A validation rule implementation for checking if a value is a valid url.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Fortunatus KIDJE (v1p3r75)
 * @github https://github.com/v1p3r75
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\LangManager;

class URLRule implements RuleInterface
{
    /**
     * Name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the URLRule class.
     *
     * @param array $parameters Parameters for the rule, specifying the list of valid values.
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the value is a valid url.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the value is valid url, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        return filter_var($value, FILTER_VALIDATE_URL); 
    }

    /**
     * Get the validation error message for this rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.url', [
            'attribute' => $this->field,
        ]);
    }
}
