<?php

use BlakvGhost\PHPValidator\LangManager;
use BlakvGhost\PHPValidator\Rules\EmailRule;
use BlakvGhost\PHPValidator\Rules\MaxLengthRule;
use BlakvGhost\PHPValidator\Rules\MinLengthRule;
use BlakvGhost\PHPValidator\Rules\RequiredRule;
use BlakvGhost\PHPValidator\Rules\StringRule;


it('validates required rule successfully', function () {
    $validator = new RequiredRule([]);

    expect($validator->passes('field', 'value', ['field' => 'value']))->toBeTrue();
    expect($validator->passes('field', '', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.required_rule', ['attribute' => 'field'])
    );
});

it('validates max length rule successfully', function () {
    $validator = new MaxLengthRule([5]);

    expect($validator->passes('field', 'value', []))->toBeTrue();
    expect($validator->passes('field', 'toolongvalue', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.max_length_rule', ['attribute' => 'field', 'max' => 5])
    );
});

it('validates email rule successfully', function () {
    $validator = new EmailRule([]);

    expect($validator->passes('email', 'test@example.com', []))->toBeTrue();
    expect($validator->passes('email', 'invalid-email', []))->toBeFalse();
    
    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.email_rule', ['attribute' => 'email'])
    );
});

it('validates string rule successfully', function () {
    $validator = new StringRule([]);
    
    expect($validator->passes('field', 'value', []))->toBeTrue();
    expect($validator->passes('field', 5, []))->toBeFalse();
    
    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.string_rule', ['attribute' => 'field'])
    );
});

it('validates min length rule successfully', function () {
    $validator = new MinLengthRule([10]);

    expect($validator->passes('field', 'toolongvalue', []))->toBeTrue();
    expect($validator->passes('field', 'less', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.min_length_rule', ['attribute' => 'field', 'min' => 10])
    );
});