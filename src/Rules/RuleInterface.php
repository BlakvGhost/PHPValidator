<?php

namespace ValidationPackage\Rules;

interface RuleInterface
{
    public function passes(string $field, $value, $data, $parameters);
    public function message();
}
