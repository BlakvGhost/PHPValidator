<?php

/**
 * PasswordRule - A validation rule implementation for checking if a field's value meets password requirements.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://username-blakvghost.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\Lang\LangManager;

class PasswordRule implements Rule
{
    /**
     * Name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the PasswordRule class.
     *
     * @param array $parameters Parameters for the rule, specifying password requirements.
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the field's value meets password requirements.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the password meets requirements, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        $minLength = $this->parameters[0] ?? 8;

        // Check if the password meets the minimum length requirement.
        if (mb_strlen($value) < $minLength) {
            return false;
        }

        // Check if the password contains at least one uppercase letter, one lowercase letter, and one digit.
        if (!preg_match('/[A-Z]/', $value) || !preg_match('/[a-z]/', $value) || !preg_match('/\d/', $value)) {
            return false;
        }

        return true;
    }


    /**
     * Get the validation error message for the password rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.password_rule', [
            'attribute' => $this->field,
        ]);
    }
}
