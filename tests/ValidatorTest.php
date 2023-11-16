<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;
use BlakvGhost\PHPValidator\LangManager;

it('throws exception if data is empty')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.empty_data')
    );

it('throws exception if rules are empty')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.empty_rules')
    );

it('throws exception if rule not found')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.rule_not_found', ['ruleName' => 'nonexistent'])
    );

it('validates string rule successfully', function () {
    $validator = new Validator(['name' => 'John'], ['name' => 'string']);
});

it('throws exception for invalid string rule')
    ->expectException(ValidatorException::class)
    ->expectExceptionMessage(
        LangManager::getTranslation('validation.string_rule', ['attribute' => 'name'])
    );
