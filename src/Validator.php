<?php

/**
 * Validator - A modern library for validating your data in your PHP applications based on predefined rules or by customizing them
 *
 * @package BlakvGhost\PHPValidator
 * @author Kabirou ALASSANE
 * @website https://kabiroualassane.link
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
    private array $validatedData = [];

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
     * Validate fields based on specified rules, entry point.
     */
    protected function validate()
    {
        foreach ($this->rules as $field => $fieldRules) {
            if (str_contains($field, '*')) {
                $this->applyRulesToWildcardField($field, $fieldRules);
            } else {
                $this->applyRulesToField($field, $fieldRules);
            }
        }

        // build $validatedData
        foreach ($this->data as $key => $value) {
            if (!isset($this->errors[$key])) {
                $this->validatedData[$key] = $value;
            }
        }
    }

    /**
     * Resolve wildcard paths within the data array.
     *
     * @param mixed $data Current data subset being examined.
     * @param array $segments Segments of the wildcard path.
     * @param string $currentPath Path prefix used for recursion.
     * @return array List of resolved paths matching the wildcard.
     */
    protected function resolveWildcardPaths($data, array $segments, string $currentPath = ''): array
    {
        $segment = array_shift($segments);
        $paths = [];

        if ($segment === '*') {
            if (!is_array($data) && !is_object($data)) return [];

            foreach ($data as $key => $value) {
                $newPath = "$currentPath$key";
                if (empty($segments)) {
                    $paths[] = $newPath;
                } else {
                    $subPaths = $this->resolveWildcardPaths($value, $segments, $newPath . '.');
                    $paths = array_merge($paths, $subPaths);
                }
            }
        } else {
            if ((is_array($data) && isset($data[$segment])) || (is_object($data) && property_exists($data, $segment))) {
                $newPath = "$currentPath$segment";
                $nextData = is_array($data) ? $data[$segment] : $data->{$segment};

                if (empty($segments)) {
                    $paths[] = $newPath;
                } else {
                    $subPaths = $this->resolveWildcardPaths($nextData, $segments, $newPath . '.');
                    $paths = array_merge($paths, $subPaths);
                }
            }
        }

        return $paths;
    }

    /**
     * Apply rules to fields that use a wildcard (*) in their path.
     *
     * @param string $wildcardField Field name containing a wildcard.
     * @param mixed $fieldRules Rules to apply to the matched paths(array, string, or RuleInterface).
     */
    protected function applyRulesToWildcardField(string $wildcardField, array|string|RuleInterface $fieldRules)
    {
        $paths = $this->resolveWildcardPaths($this->data, explode('.', $wildcardField));
        if (empty($paths)) {
            $this->applyRulesToField($wildcardField, $fieldRules);
            return;
        }

        foreach ($paths as $path) {
            $this->applyRulesToField($path, $fieldRules);
        }
    }

    /**
     * Apply validation rules to a specific field.
     *
     * @param string $field The field name to validate.
     * @param mixed $fieldRules The rules to apply (array, string, or RuleInterface).
     */
    protected function applyRulesToField(string $field, array|string|RuleInterface $fieldRules)
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

        $skipNullRules = ['required', 'not_nullable'];

        if ($value === null && !in_array($ruleName, $skipNullRules)) {
            return;
        }

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
     * Resolve a wildcard segment recursively in the data array to fetch the value.
     *
     * @param mixed $data The current level of data to process.
     * @param array $segments Remaining segments of the path.
     * @return mixed The resolved value or null.
     */
    protected function resolveWildcardSegment($data, array $segments)
    {
        $segment = array_shift($segments);

        if ($segment === '*') {
            if (!is_array($data) && !is_object($data)) return null;

            $results = [];
            foreach ($data as $item) {
                $resolved = $this->resolveWildcardSegment($item, $segments);
                if (is_array($resolved)) {
                    $results = array_merge($results, $resolved);
                } elseif ($resolved !== null) {
                    $results[] = $resolved;
                }
            }
            return $results;
        }

        if (is_object($data)) {
            if (property_exists($data, $segment)) {
                return $this->resolveWildcardSegment($data->{$segment}, $segments);
            }
            return null;
        }

        if (is_array($data)) {
            if (array_key_exists($segment, $data)) {
                return $this->resolveWildcardSegment($data[$segment], $segments);
            } elseif ($segment && ctype_digit($segment) && isset($data[(int)$segment])) {
                return $this->resolveWildcardSegment($data[(int)$segment], $segments);
            }
        }

        return $data;
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

    /**
     * Returns only validated data (fields without errors)
     */
    public function validated(): array
    {
        $validated = [];

        foreach ($this->data as $key => $value) {
            if (!array_key_exists($key, $this->errors)) {
                $validated[$key] = $value;
            }
        }

        return $validated;
    }
}
