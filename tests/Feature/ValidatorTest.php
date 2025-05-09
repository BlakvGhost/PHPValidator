<?php

use BlakvGhost\PHPValidator\Lang\LangManager;
use BlakvGhost\PHPValidator\Mapping\RulesMaped;
use BlakvGhost\PHPValidator\Rules\RequiredRule;
use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;

// it('throws exception if data is empty', function () {
//     expect(fn () => new Validator([], ['name' => 'string']))
//         ->toThrow(ValidatorException::class, LangManager::getTranslation('validation.empty_data'));
// });

it('throws exception if rules are empty', function () {
    expect(fn() => new Validator(['name' => 'John'], []))
        ->toThrow(ValidatorException::class, LangManager::getTranslation('validation.empty_rules'));
});

it('throws exception if rule not found', function () {
    expect(fn() => new Validator(['name' => 'John'], ['name' => 'nonexistent']))
        ->toThrow(ValidatorException::class, LangManager::getTranslation('validation.rule_not_found', ['ruleName' => 'nonexistent']));
});

it('validates custom rule (required) rule successfully', function () {

    $validator = new Validator(['field' => 'value'], ['field' => new RequiredRule([])]);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'value'], ['field' => [new RequiredRule([])]]);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'value'], ['field' => ['string', new RequiredRule([])]]);
    expect($validator->isValid())->toBeTrue();

    RulesMaped::addRule('custom_required', RequiredRule::class);

    $validator = new Validator(['field' => 'value'], ['field' => 'string|custom_required']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => ''], ['field' => new RequiredRule([])]);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.required_rule', ['attribute' => 'field'])
    );
});

it('validates rule with custom error message', function () {

    $errorMessage = "Je teste une règle custom";

    $validator = new Validator(
        ['field' => ''],
        ['field' => 'required'],
        [
            'field' => [
                'required' => $errorMessage
            ]
        ]
    );
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe($errorMessage);
});
