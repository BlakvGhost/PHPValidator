<?php

/**
 * Validator - A modern library for validating your data in your PHP applications based on predefined rules or by customizing them
 *
 * @package BlakvGhost\PHPValidator
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator;

use BlakvGhost\PHPValidator\Rules\RuleInterface;
use BlakvGhost\PHPValidator\ValidatorException;

class Validator
{

    private $errors = [];

    /**
     * Constructor of the Validator class.
     *
     * @param array $data Data to be validated.
     * @param array $rules Validation rules to apply.
     */
    public function __construct(private array $data, private array $rules)
    {
        $this->validateConstructorInputs();
        $this->validate();
    }

    /**
     * Parse a rule to extract the name and any parameters.
     *
     * @param string $rule Rule to parse.
     * @return array Array containing the rule name and its parameters.
     */
    protected function parseRule(string $rule): array
    {
        $segments = explode(':', $rule, 2);

        $ruleName = $segments[0];
        $parameters = isset($segments[1]) ? explode(',', $segments[1]) : [];

        return [$ruleName, $parameters];
    }

    /**
     * Resolve the name of a rule into a fully qualified class namespace.
     *
     * @param string $ruleName Rule name.
     * @return string Fully qualified class namespace of the rule class.
     * @throws ValidatorException If the rule does not exist.
     */
    protected function resolveRuleClass($ruleName): string
    {
        if (is_a($ruleName, RuleInterface::class, true)) {
            return $ruleName::class;
        }

        $ruleParts = explode('_', $ruleName);
        $className = implode('', array_map('ucfirst', $ruleParts)) . 'Rule';

        $fullClassName = "BlakvGhost\\PHPValidator\\Rules\\$className";

        if (!class_exists($fullClassName)) {

            $translatedMessage = LangManager::getTranslation('validation.rule_not_found', [
                'ruleName' => $ruleName,
            ]);

            throw new ValidatorException($translatedMessage);
        }

        return $fullClassName;
    }

    /**
     * Add an error to the list of errors.
     *
     * @param string $field Field associated with the error.
     * @param string $message Error message.
     */
    protected function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    /**
     * Validate fields based on specified rules.
     */
    protected function validate()
    {
        foreach ($this->rules as $field => $fieldRules) {

            if (is_a($fieldRules, RuleInterface::class, true)) {
                return $this->checkPasses($fieldRules, $field);
            }

            $rulesArray = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

            foreach ($rulesArray as $rule) {

                if (is_a($rule, RuleInterface::class, true)) {
                    $this->checkPasses($rule, $field);
                } else {
                    list($ruleName, $parameters) = $this->parseRule($rule);
                    $ruleClass = $this->resolveRuleClass($ruleName);

                    $validator = new $ruleClass($parameters);

                    $this->checkPasses($validator, $field);
                }
            }
        }
    }

    /**
     * Check if a rule passes validation and add an error if it fails.
     *
     * @param mixed $validator Instance of the rule to check.
     * @param string $field Field associated with the rule.
     */
    protected function checkPasses(mixed $validator, string $field)
    {
        if (isset($this->data[$field]) && !$validator->passes($field, $this->data[$field], $this->data)) {
            $this->addError($field, $validator->message());
        }
    }


    /**
     * Validate constructor inputs to ensure required data and rules are provided.
     *
     * @throws ValidatorException If data or rules are empty.
     */
    protected function validateConstructorInputs()
    {
        if (empty($this->data)) {
            throw new ValidatorException(LangManager::getTranslation('validation.empty_data'));
        }

        if (empty($this->rules)) {
            throw new ValidatorException(LangManager::getTranslation('validation.empty_rules'));
        }
    }

    /**
     * Retrieve the list of errors.
     *
     * @return array List of errors.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Check if validation is successful (no errors).
     *
     * @return bool True if validation is successful, otherwise false.
     */
    public function isValid(): bool
    {
        return count($this->errors) < 1;
    }
}
