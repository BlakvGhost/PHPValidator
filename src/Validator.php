<?php

namespace BlakvGhost\PHPValidator;

class Validator
{
    protected $errors = [];

    public function __construct(protected array $data, protected array $rules)
    {
        $this->validate();
    }

    public function validate()
    {
        // TODO
    }
}
