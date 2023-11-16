<?php

use BlakvGhost\PHPValidator\Rules\EmailRule;
use BlakvGhost\PHPValidator\Rules\StringRule;

it('validates string rule successfully')
    ->does(fn () => (new EmailRule([]))->passes('name', 'John', []))
    ->assertTrue();