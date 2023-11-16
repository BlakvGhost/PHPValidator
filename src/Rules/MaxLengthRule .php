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
        
        $maxLength = $this->parameters[0] ?? 0;
        return is_string($value) && mb_strlen($value) <= $maxLength;
    }

    public function message(): string
    {
        return LangManager::getTranslation('validation.max_length_rule', [
            'attribute' => $this->field,
            'max' => $this->parameters[0] ?? 0,
        ]);
    }
}
