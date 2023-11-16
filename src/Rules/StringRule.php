<?php

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\LangManager;


class StringRule implements RuleInterface
{
    protected $field;

    public function __construct(protected array $parameters)
    {
    }

    public function passes(string $field, $value, array $data): bool
    {
        $this->field = $field;
        return is_string($value);
    }

    public function message(): string
    {
        return LangManager::getTranslation('validation.string_rule', [
            'ruleName' => $this->field,
        ]);
    }
}
