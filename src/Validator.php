<?php

namespace BlakvGhost\PHPValidator;

use BlakvGhost\PHPValidator\Rules\RuleInterface;

class Validator
{
    // new Validator([
    //     'username' => 'BlakvGhost',
    //     'email' => 'kabirou2001@gmail.com',
    // ], [
    //     'username' => "required|string:25",
    //      'email' => new Email(),
    // ]);

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

    protected function resolveRuleClass($ruleName): string
    {
        if (is_a($ruleName, RuleInterface::class, true)) {
            return $ruleName::class;
        }

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

    protected function checkPasses($validator, $field)
    {
        if (!$validator->passes($field, $this->data[$field] ?? null, $this->data)) {
            $this->addError($field, $field->message());
        }
    }
    public function validate()
    {
        foreach ($this->rules as $field => $fieldRules) {

            if (is_a($fieldRules, RuleInterface::class, true)) {
                return $this->checkPasses($fieldRules, $field);
            }

            $rulesArray = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

            foreach ($rulesArray as $rule) {
                list($ruleName, $parameters) = $this->parseRule($rule);
                $ruleClass = $this->resolveRuleClass($ruleName);

                $validator = new $ruleClass($parameters);

                $this->checkPasses($validator, $field);
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
