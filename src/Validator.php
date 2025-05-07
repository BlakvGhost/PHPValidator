<?php

/**
 * Validator - A modern library for validating your data in your PHP applications based on predefined rules or by customizing them
 *
 * @package BlakvGhost\PHPValidator
 * @author Kabirou ALASSANE
 * @website https://username-blakvghost.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator;

use BlakvGhost\PHPValidator\Lang\LangManager;
use BlakvGhost\PHPValidator\Mapping\RulesMaped;
use BlakvGhost\PHPValidator\Contracts\Rule as RuleInterface;
use BlakvGhost\PHPValidator\ValidatorException;

class Validator extends RulesMaped
{

    private array $errors = [];

    private const LANGUAGE = 'en';

    /**
     * Constructor of the Validator class.
     *
     * @param array $data Data to be validated.
     * @param array $rules Validation rules to apply.
     * @param array $messages Validation rules messages to apply when failed.
     */
    public function __construct(
        private array $data,
        private array $rules,
        private array $messages = [],
        private string $lang = self::LANGUAGE,
    ) {
        LangManager::$lang = $this->lang;
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

        return $this->getRule($ruleName);
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

            // Si le champ contient un '*', on décompose en plusieurs sous-champs
            if (strpos($field, '*') !== false) {
                // Trouver la base et l'index de la wildcard
                [$baseField, $wildcard] = explode('.', $field, 2);
                $arrayData = $this->getNestedValue($this->data, $baseField);

                // Appliquer la règle pour chaque élément du tableau
                if (is_array($arrayData)) {
                    foreach ($arrayData as $index => $item) {
                        $newField = "$baseField.$index.$wildcard";
                        // Appliquer les règles sur chaque élément du tableau
                        $this->applyRulesToField($newField, $fieldRules);
                    }
                }
            } else {
                // Appliquer normalement la règle si pas de wildcard
                $this->applyRulesToField($field, $fieldRules);
            }
        }
    }

    protected function applyRulesToField(string $field, $fieldRules)
    {
        if (is_a($fieldRules, RuleInterface::class, true)) {
            return $this->checkPasses($fieldRules, $field);
        }

        $rulesArray = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

        foreach ($rulesArray as $rule) {
            if (is_a($rule, RuleInterface::class, true)) {
                $this->checkPasses($rule, $field);
            } else {
                [$ruleName, $parameters] = $this->parseRule($rule);
                $ruleClass = $this->resolveRuleClass($ruleName);

                $validator = new $ruleClass($parameters);
                $this->checkPasses($validator, $field, $ruleName);
            }
        }
    }


    /**
     * Check if a rule passes validation and add an error if it fails.
     *
     * @param mixed $validator Instance of the rule to check.
     * @param string $field Field associated with the rule.
     * @param ?string $ruleName Associated rule alias.
     */
    protected function checkPasses(mixed $validator, string $field, ?string $ruleName = null)
    {
        $value = $this->getNestedValue($this->data, $field);

        if ($value === null && $ruleName !== 'required') return;
        var_dump($validator->passes($field, $value, $this->data), $value, $field);
        if (!$validator->passes($field, $value, $this->data)) {

            $assert = isset($ruleName) && isset($this->messages[$field][$ruleName]);
            $message = $assert ? $this->messages[$field][$ruleName] : $validator->message();
            $this->addError($field, $message);
        }
    }

    /**
     * Retrieve a nested value from the data array using dot notation.
     *
     * @param array $data Data to search in.
     * @param string $key Key to search for, using dot notation for nested keys.
     * @return mixed Resolved value or null if not found.
     */
    protected function getNestedValue(array $data, string $key)
    {
        $segments = explode('.', $key);
        return $this->resolveWildcardSegment($data, $segments);
    }

    /**
     * Resolve a wildcard segment in the data array.
     *
     * @param mixed $data Data to resolve.
     * @param array $segments Array of segments to resolve.
     * @return mixed Resolved value or null if not found.
     */
    protected function resolveWildcardSegment($data, array $segments)
    {
        $segment = array_shift($segments);

        var_dump($segment, $data);
        if ($segment === '*') {
            if (!is_array($data)) {
                return null;
            }

            $results = [];
            foreach ($data as $item) {
                $resolved = $this->resolveWildcardSegment($item, $segments);
                if (is_array($resolved)) {
                    $results = array_merge($results, $resolved);
                } elseif (!is_null($resolved)) {
                    $results[] = $resolved;
                }
            }
            return $results;
        }

        if (is_array($data)) {
            if (array_key_exists($segment, $data)) {
                return $this->resolveWildcardSegment($data[$segment], $segments);
            } elseif (ctype_digit($segment) && isset($data[(int) $segment])) {
                return $this->resolveWildcardSegment($data[(int) $segment], $segments);
            }
        }

        return null;
    }



    /**
     * Validate constructor inputs to ensure required data and rules are provided.
     *
     * @throws ValidatorException If data or rules are empty.
     */
    protected function validateConstructorInputs()
    {
        if (!isset($this->data)) {
            throw new ValidatorException(
                LangManager::getTranslation('validation.empty_data')
            );
        }

        if (empty($this->rules)) {
            throw new ValidatorException(
                LangManager::getTranslation('validation.empty_rules')
            );
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
