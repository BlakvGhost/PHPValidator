<?php

namespace BlakvGhost\PHPValidator;

class Validator
{
    protected $data;
    protected $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function validate()
    {
        // TODO
    }

}
