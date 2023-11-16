<?php

use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;
use BlakvGhost\PHPValidator\LangManager;

it('throws exception if data is empty')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.empty_data')
    )
    ->incomplete();

it('throws exception if rules are empty')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.empty_rules')
    )
    ->incomplete();

it('throws exception if rule not found')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.rule_not_found', ['ruleName' => 'nonexistent'])
    )
    ->incomplete();

it('validates string rule successfully')
    ->does(fn () => new Validator(['name' => 'John'], ['name' => 'string']))
    ->incomplete();

it('throws exception for invalid string rule')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.string_rule', ['attribute' => 'name'])
    )
    ->does(fn () => new Validator(['name' => 123], ['name' => 'string']));

