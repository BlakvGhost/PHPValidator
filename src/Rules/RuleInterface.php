<?php

/**
 * RuleInterface - Interface for defining validation rules in the PHPValidator package.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

interface RuleInterface
{
    /**
     * Constructor of the RuleInterface.
     *
     * @param array $parameters Parameters for the rule, if any.
     */
    public function __construct(...$parameters);

    /**
     * Check if the given field passes the validation rule.
     *
     * @param string $field Name of the field being validated.
     * @param string $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the validation rule passes, false otherwise.
     */
    public function passes(string $field, string $value, array $data): bool;

    /**
     * Get the validation error message for the rule.
     *
     * @return string Validation error message.
     */
    public function message(): string;
}
