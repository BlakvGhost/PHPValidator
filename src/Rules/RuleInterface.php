<?php

namespace ValidationPackage\Rules;

interface RuleInterface
{
    public function __contruct(array $parameters);
    public function passes(string $field, string $value, array $data);
    public function message(): string;
}
