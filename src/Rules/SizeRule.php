<?php

/**
 * InRule - A validation rule implementation for checking value size.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Fortunatus KIDJE (v1p3r75)
 * @github https://github.com/v1p3r75
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\LangManager;

class SizeRule implements RuleInterface
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
     * Check value size.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the value have a valid size, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        $total = $this->parameters[0] ?? 0;

        if (is_string($value)) {

            return strlen($value) == $total;
        }

        if (is_int($value)) {

            return $value == $total;
        }
        
        if (is_array($value)) {

            return count($value) == $total;
        }

        if (is_file($value)) {

            if (isset($_FILES[$value]) && $_FILES[$value]["error"] == 0) {
                // Get the file size in bytes
                $size = $_FILES[$value]["size"];
        
                // Convert bytes to kilobytes
                $size_kb = $size / 1024; // kilobytes
        
                return $size_kb == $total;
            }

            return false;
        }

        return false;
    }

    /**
     * Get the validation error message for this rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.size', [
            'attribute' => $this->field,
            'value' => $this->parameters[0]
        ]);
    }
}
