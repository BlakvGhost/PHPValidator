<?php

/**
 * ActiveUrlRule - A validation rule implementation for checking if a URL is active.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://username-blakvghost.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\Lang\LangManager;

class ActiveURLRule implements Rule
{
    /**
     * The name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the ActiveURLRule class.
     *
     * @param array $parameters Parameters for the rule (none needed for this rule).
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the given URL is active.
     *
     * @param string $field The name of the field being validated.
     * @param mixed $value The value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the URL is active, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        // Check if the value is a valid URL and has an active DNS record.
        return filter_var($value, FILTER_VALIDATE_URL) !== false && checkdnsrr(parse_url($value, PHP_URL_HOST));
    }

    /**
     * Get the validation error message for the active URL rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.active_url', [
            'attribute' => $this->field,
        ]);
    }
}
