<?php

use BlakvGhost\PHPValidator\LangManager;
use BlakvGhost\PHPValidator\Rules\AcceptedIfRule;
use BlakvGhost\PHPValidator\Rules\AcceptedRule;
use BlakvGhost\PHPValidator\Rules\ActiveURLRule;
use BlakvGhost\PHPValidator\Rules\AlphaRule;
use BlakvGhost\PHPValidator\Rules\ConfirmedRule;
use BlakvGhost\PHPValidator\Rules\EmailRule;
use BlakvGhost\PHPValidator\Rules\InRule;
use BlakvGhost\PHPValidator\Rules\StringRule;
use BlakvGhost\PHPValidator\Rules\RequiredRule;
use BlakvGhost\PHPValidator\Rules\MaxLengthRule;
use BlakvGhost\PHPValidator\Rules\MinLengthRule;
use BlakvGhost\PHPValidator\Rules\NullableRule;
use BlakvGhost\PHPValidator\Rules\NumericRule;
use BlakvGhost\PHPValidator\Rules\PasswordRule;
use BlakvGhost\PHPValidator\Rules\SameRule;

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

it('validates alpha rule successfully', function () {
    $validator = new AlphaRule([]);

    expect($validator->passes('field', 'Alphabetic', []))->toBeTrue();
    expect($validator->passes('field', 'Alpha123', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.alpha_rule', ['attribute' => 'field'])
    );
});

it('validates accepted if rule successfully', function () {
    $validator = new AcceptedIfRule(['other_field']);

    expect($validator->passes('field', 'some_value', ['other_field' => true]))->toBeTrue();
    expect($validator->passes('field', 'some_value', ['other_field' => false]))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.accepted_if', ['attribute' => 'field', 'other' => 'other_field'])
    );
});

it('validates accepted rule successfully', function () {
    $validator = new AcceptedRule([]);

    expect($validator->passes('field', '1', []))->toBeTrue();
    expect($validator->passes('field', 'true', []))->toBeTrue();
    expect($validator->passes('field', 'on', []))->toBeTrue();
    expect($validator->passes('field', 'yes', []))->toBeTrue();
    expect($validator->passes('field', 'invalid_value', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.accepted', ['attribute' => 'field'])
    );
});

it('validates same rule successfully', function () {
    $validator = new SameRule(['other_field']);

    expect($validator->passes('field', 'value', ['other_field' => 'value']))->toBeTrue();
    expect($validator->passes('field', 'value', ['other_field' => 'different_value']))->toBeFalse();
    expect($validator->passes('field', 'value', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.same_rule', [
            'attribute' => 'field',
            'otherAttribute' => 'other_field',
        ])
    );
});

it('validates password rule successfully', function () {
    $validator = new PasswordRule([8]);

    expect($validator->passes('password', 'StrongPwd1', []))->toBeTrue();
    expect($validator->passes('password', 'Short1', []))->toBeFalse();
    expect($validator->passes('password', 'lowercase1', []))->toBeFalse();
    expect($validator->passes('password', 'UPPERCASE1', []))->toBeFalse();
    expect($validator->passes('password', 'NoDigit', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.password_rule', [
            'attribute' => 'password',
        ])
    );
});

it('validates numeric rule successfully', function () {
    $validator = new NumericRule([]);

    expect($validator->passes('numericField', 123, []))->toBeTrue();
    expect($validator->passes('numericField', '456', []))->toBeTrue();
    expect($validator->passes('numericField', 'NotNumeric', []))->toBeFalse();
    expect($validator->passes('numericField', null, []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.numeric_rule', [
            'attribute' => 'numericField',
        ])
    );
});

it('validates nullable rule successfully', function () {
    $validator = new NullableRule([]);

    expect($validator->passes('nullableField', null, []))->toBeTrue();
    expect($validator->passes('nullableField', 'NotNull', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.nullable_rule', [
            'attribute' => 'nullableField',
        ])
    );
});

it('validates in rule successfully', function () {
    $validValues = ['value1', 'value2', 'value3'];
    $validator = new InRule([$validValues]);

    expect($validator->passes('field', 'value2', []))->toBeTrue();
    expect($validator->passes('field', 'invalidValue', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.in_rule', [
            'attribute' => 'field',
            'values' => implode(', ', $validValues),
        ])
    );
});

it('validates confirmed rule successfully', function () {
    $confirmationFieldName = 'confirmation_field';
    $validator = new ConfirmedRule([$confirmationFieldName]);

    // When the confirmation field is present and its value matches the field's value, the validation should pass.
    $data = [
        'field' => 'value',
        $confirmationFieldName => 'value',
    ];
    expect($validator->passes('field', 'value', $data))->toBeTrue();

    // When the confirmation field is present but its value doesn't match the field's value, the validation should fail.
    $data = [
        'field' => 'value1',
        $confirmationFieldName => 'value2',
    ];
    expect($validator->passes('field', 'value1', $data))->toBeFalse();

    // When the confirmation field is not present, the validation should fail.
    $data = [
        'field' => 'value',
    ];
    expect($validator->passes('field', 'value', $data))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.confirmed_rule', [
            'attribute' => 'field',
            'confirmedAttribute' => $confirmationFieldName,
        ])
    );
});

it('validates active URL rule successfully', function () {
    $validator = new ActiveURLRule([]);

    // When the URL is valid and has an active DNS record, the validation should pass.
    $data = [
        'field' => 'https://www.example.com',
    ];
    expect($validator->passes('field', 'https://www.example.com', $data))->toBeTrue();

    // When the URL is valid but doesn't have an active DNS record, the validation should fail.
    $data = [
        'field' => 'https://nonexistent.example.com',
    ];
    expect($validator->passes('field', 'https://nonexistent.example.com', $data))->toBeFalse();

    // When the URL is not valid, the validation should fail.
    $data = [
        'field' => 'invalid-url',
    ];
    expect($validator->passes('field', 'invalid-url', $data))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.active_url', [
            'attribute' => 'field',
        ])
    );
});
