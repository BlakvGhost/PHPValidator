<?php

namespace BlakvGhost\PHPValidator\Rules;

interface RuleInterface
{
    public function __construct(array $parameters);
    public function passes(string $field, string $value, array $data);
    public function message(): string;
}
