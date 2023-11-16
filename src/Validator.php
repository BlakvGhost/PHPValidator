<?php

namespace BlakvGhost\PHPValidator;

use BlakvGhost\PHPValidator\ValidatorException;

class Validator
{
    protected $errors = [];

    public function __construct(private array $data, protected array $rules)
    {
        $this->validateConstructorInputs();
        $this->validate();
    }
    
    public static function validate()
    {
        // TODO
    }

    private function validateConstructorInputs()
    {
        if (!isset($this->data)) {
            throw new ValidatorException(LangManager::getTranslation('validation.empty_data'));
        }

        if (!isset($this->rules) || count($this->rules) < 1) {
            throw new ValidatorException(LangManager::getTranslation('validation.empty_rules'));
        }
    }
}
