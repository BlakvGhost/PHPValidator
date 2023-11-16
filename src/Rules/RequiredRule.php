<?php

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\LangManager;


class RequiredRule implements RuleInterface
{
    protected $field;

    public function __construct(protected array $parameters)
    {
    }

    public function passes(string $field, $value, array $data): bool
    {
        $this->field = $field;
        return isset($data[$field]) && !empty($data[$field]);
    }

    public function message(): string
    {
        return LangManager::getTranslation('validation.required_rule', [
            'attribute' => $this->field,
        ]);
    }
}
