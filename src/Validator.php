<?php

namespace BlakvGhost\PHPValidator;

use BlakvGhost\PHPValidator\Rules\RuleInterface;

class Validator
{
    protected $errors = [];

    public function __construct(private array $data, protected array $rules)
    {
        $this->validateConstructorInputs();
        $this->validate();
    }

    protected function parseRule(string $rule): array
    {
        $segments = explode(':', $rule, 2);

        $ruleName = $segments[0];
        $parameters = isset($segments[1]) ? explode(',', $segments[1]) : [];

        return [$ruleName, $parameters];
    }

    protected function resolveRuleClass(string $ruleName): string
    {
        $className = ucfirst($ruleName) . 'Rule';

        $fullClassName = "BlakvGhost\\PHPValidator\\Rules\\$className";

        if (!class_exists($fullClassName)) {
            $translatedMessage = LangManager::getTranslation('validation.rule_not_found', [
                'ruleName' => $ruleName,
            ]);

            throw new ValidatorException($translatedMessage);
        }

        return $fullClassName;
    }

    protected function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    protected function validateConstructorInputs()
    {
        if (empty($this->data)) {
            throw new ValidatorException(LangManager::getTranslation('validation.empty_data'));
        }

        if (empty($this->rules)) {
            throw new ValidatorException(LangManager::getTranslation('validation.empty_rules'));
        }
    }

    public function validate()
    {
        foreach ($this->rules as $field => $fieldRules) {
            $rulesArray = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

            foreach ($rulesArray as $rule) {
                list($ruleName, $parameters) = $this->parseRule($rule);
                $ruleClass = $this->resolveRuleClass($ruleName);

                $validator = new $ruleClass($parameters);

                if (!$validator->passes($field, $this->data[$field] ?? null, $this->data, $parameters)) {
                    $this->addError($field, $validator->message());
                }
            }
        }
    }

    public static function getErrors(): array
    {
        return self::$errors;
    }

    public static function isValid(): bool
    {
        return count(self::$errors) < 1;
    }
}
