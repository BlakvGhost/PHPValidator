<?php

/**
 * AcceptedIfRule - A validation rule implementation for checking if a value is considered "accepted" based on another field.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\Lang\LangManager;

class AcceptedIfRule implements Rule
{
    /**
     * The name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * The other field that determines if the value is considered "accepted".
     *
     * @var string
     */
    protected $otherField;

    /**
     * Constructor of the AcceptedIfRule class.
     *
     * @param array $parameters Parameters for the rule, specifying the other field.
     */
    public function __construct(protected array $parameters)
    {
        // Set the other field from the parameters.
        $this->otherField = $parameters[0] ?? '';
    }

    /**
     * Check if the given value is considered "accepted" based on another field.
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

        // Check if the other field is equal to a truthy value.
        return $data[$this->otherField] == true;
    }

    /**
     * Get the validation error message for the accepted if rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.accepted_if', [
            'attribute' => $this->field,
            'other' => $this->otherField,
        ]);
    }
}
