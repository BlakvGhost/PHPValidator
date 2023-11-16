<?php

use BlakvGhost\PHPValidator\ValidatorException;
use BlakvGhost\PHPValidator\LangManager;
use BlakvGhost\PHPValidator\Rules\StringRule;
use BlakvGhost\PHPValidator\Rules\RequiredRule;
use BlakvGhost\PHPValidator\Rules\MaxLengthRule;


it('validates string rule successfully')
    ->does(fn () => (new StringRule([]))->passes('name', 'John', []))
    ->assertTrue();

it('throws exception for invalid string rule')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.string_rule', ['attribute' => 'name'])
    )
    ->does(fn () => (new StringRule([]))->passes('name', 123, []));

it('validates required rule successfully')
    ->does(fn () => (new RequiredRule([]))->passes('name', 'John', []))
    ->assertTrue();

it('throws exception for invalid required rule')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.required_rule', ['attribute' => 'name'])
    )
    ->does(fn () => (new RequiredRule([]))->passes('name', null, []));

it('validates max length rule successfully')
    ->does(fn () => (new MaxLengthRule([5]))->passes('name', 'John', []))
    ->assertTrue();

it('throws exception for invalid max length rule')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.max_length_rule', ['attribute' => 'name', 'max' => 5])
    )
    ->does(fn () => (new MaxLengthRule([5]))->passes('name', 'Jonathan', []));
