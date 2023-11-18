<?php

use BlakvGhost\PHPValidator\LangManager;
use BlakvGhost\PHPValidator\Rules\AcceptedIfRule;
use BlakvGhost\PHPValidator\Rules\AcceptedRule;
use BlakvGhost\PHPValidator\Rules\ActiveURLRule;
use BlakvGhost\PHPValidator\Rules\AlphaNumericRule;
use BlakvGhost\PHPValidator\Rules\AlphaRule;
use BlakvGhost\PHPValidator\Rules\BooleanRule;
use BlakvGhost\PHPValidator\Rules\ConfirmedRule;
use BlakvGhost\PHPValidator\Rules\FileRule;
use BlakvGhost\PHPValidator\Rules\InRule;
use BlakvGhost\PHPValidator\Rules\JsonRule;
use BlakvGhost\PHPValidator\Rules\LowerRule;
use BlakvGhost\PHPValidator\Rules\RequiredWithRule;
use BlakvGhost\PHPValidator\Rules\SizeRule;
use BlakvGhost\PHPValidator\Rules\StringRule;
use BlakvGhost\PHPValidator\Rules\MinLengthRule;
use BlakvGhost\PHPValidator\Rules\NotInRule;
use BlakvGhost\PHPValidator\Rules\NullableRule;
use BlakvGhost\PHPValidator\Rules\NumericRule;
use BlakvGhost\PHPValidator\Rules\PasswordRule;
use BlakvGhost\PHPValidator\Rules\SameRule;
use BlakvGhost\PHPValidator\Rules\UpperRule;
use BlakvGhost\PHPValidator\Rules\UrlRule;
use BlakvGhost\PHPValidator\Rules\ValidIpRule;
use BlakvGhost\PHPValidator\Validator;


it('validates required rule successfully', function () {

    $validator = new Validator(['field' => 'value'], ['field' => 'required']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => ''], ['field' => 'required']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.required_rule', ['attribute' => 'field'])
    );
});

it('validates max length rule successfully', function () {

    $validator = new Validator(['username' => 'value'], ['username' => 'max_length:5']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['username' => 'value_long'], ['username' => 'max_length:5']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['username'][0])->toBe(
        LangManager::getTranslation('validation.max_length_rule', [
            'attribute' => 'username',
            'max' => 5,
        ])
    );
});

it('validates email rule successfully', function () {

    $validator = new Validator(['email' => 'test@example.com'], ['email' => 'email']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['email' => 'invalid-email'], ['email' => 'email']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['email'][0])->toBe(
        LangManager::getTranslation('validation.email_rule', ['attribute' => 'email'])
    );
});

it('validates string rule successfully', function () {

    $validator = new Validator(['field' => 'value'], ['field' => 'string']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 5], ['field' => 'string']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.string_rule', ['attribute' => 'field'])
    );
});

it('validates min length rule successfully', function () {

    $validator = new Validator(['field' => 'toolongvalue'], ['field' => 'min_length:10']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'less'], ['field' => 'min_length:10']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.min_length_rule', ['attribute' => 'field', 'min' => 10])
    );
});

it('validates alpha rule successfully', function () {

    $validator = new Validator(['field' => 'Alphabetic'], ['field' => 'alpha']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'Alpha123'], ['field' => 'alpha']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.alpha_rule', ['attribute' => 'field'])
    );
});

it('validates accepted if rule successfully', function () {

    $validator = new Validator(['field' => 'some_field', 'other_field' => true], ['field' => 'accepted_if:other_field']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'some_field', 'other_field' => false], ['other_field' => 'accepted_if:other_field']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.accepted_if', ['attribute' => 'field', 'other' => 'other_field'])
    );
});

it('validates accepted rule successfully', function () {

    $validator = new Validator(['field' => '1'], ['field' => 'accepted']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'true'], ['field' => 'accepted']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'on'], ['field' => 'accepted']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'yes'], ['field' => 'accepted']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'invalid_value'], ['field' => 'accepted']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.accepted', ['attribute' => 'field'])
    );
});

it('validates same rule successfully', function () {

    $validator = new Validator(['field' => 'value', 'other_field' => 'value'], ['field' => 'same:other_field']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'value', 'other_field' => 'different_value'], ['field' => 'same:other_field']);
    expect($validator->isValid())->toBeFalse();
    
    $validator = new Validator(['field' => 'value'], ['field' => 'same:other_field']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.same_rule', [
            'attribute' => 'field',
            'otherAttribute' => 'other_field',
        ])
    );
});

it('validates password rule successfully', function () {

    $validator = new Validator(['password' => 'StrongPwd1'], ['password' => 'password:8']);
    expect($validator->isValid())->toBeTrue();
    
    $validator = new Validator(['password' => 'StrongPwd1'], ['password' => 'password']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['password' => 'Short1'], ['password' => 'password']);
    expect($validator->isValid())->toBeFalse();

    $validator = new Validator(['password' => 'lowercase1'], ['password' => 'password']);
    expect($validator->isValid())->toBeFalse();
    
    $validator = new Validator(['password' => 'UPPERCASE1'], ['password' => 'password']);
    expect($validator->isValid())->toBeFalse();
    
    $validator = new Validator(['password' => 'NoDigit'], ['password' => 'password']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.password_rule', [
            'attribute' => 'password',
        ])
    );
});

it('validates numeric rule successfully', function () {

    $validator = new Validator(['numericField' => 123], ['numericField' => 'numeric']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['numericField' => '456'], ['numericField' => 'numeric']);
    expect($validator->isValid())->toBeFalse();

    $validator = new Validator(['numericField' => 'NotNumeric'], ['numericField' => 'numeric']);
    expect($validator->isValid())->toBeFalse();
    
    $validator = new Validator(['numericField' => null], ['numericField' => 'numeric']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.numeric_rule', [
            'attribute' => 'numericField',
        ])
    );
});

it('validates nullable rule successfully', function () {

    $validator = new Validator(['nullableField' => null], ['nullableField' => 'nullable']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['nullableField' => 'NotNull'], ['nullableField' => 'nullable']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.nullable_rule', [
            'attribute' => 'nullableField',
        ])
    );
});

it('validates in rule successfully', function () {
    $validValues = 'value1,value2,value3';

    $validator = new Validator(['field' => 'value2'], ['field' => 'in:' . $validValues]);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'invalidValue'], ['field' => 'in:' . $validValues]);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.in_rule', [
            'attribute' => 'field',
            'values' => $validValues,
        ])
    );
});

it('validates not in rule successfully', function () {

    $values = 'value1,value2,value3';

    $validator = new Validator(['field' => 'other_value'], ['field' => 'not_in:' . $values]);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'value1'], ['field' => 'not_in:' . $values]);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.not_in_rule', [
            'attribute' => 'field',
            'values' => $values,
        ])
    );
});

it('validates confirmed rule successfully', function () {
    $confirmationFieldName = 'confirmation_field';

    $data = [
        'field' => 'value',
        $confirmationFieldName => 'value',
    ];
    $validator = new Validator($data, ['field' => 'confirmed:' . $confirmationFieldName]);
    expect($validator->isValid())->toBeTrue();

    $data = [
        'field' => 'value1',
        $confirmationFieldName => 'value2',
    ];
    $validator = new Validator($data, ['field' => 'confirmed:' . $confirmationFieldName]);
    expect($validator->isValid())->toBeFalse();

    $data = [
        'field' => 'value',
    ];
    $validator = new Validator($data, ['field' => 'confirmed:' . $confirmationFieldName]);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.confirmed_rule', [
            'attribute' => 'field',
            'confirmedAttribute' => $confirmationFieldName,
        ])
    );
});

it('validates active URL rule successfully', function () {

    $validator = new Validator(['field' => 'https://example.com'], ['field' => 'active_url']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'https://nonexistent.example.com'], ['field' => 'active_url']);
    expect($validator->isValid())->toBeFalse();

    $validator = new Validator(['field' => 'invalid-url'], ['field' => 'active_url']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.active_url', [
            'attribute' => 'field',
        ])
    );
});

it('validates lowercase rule successfully', function () {

    $validator = new Validator(['field' => 'lowercase'], ['field' => 'lower']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'UPPERCASE'], ['field' => 'lower']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.lowercase_rule', [
            'attribute' => 'field',
        ])
    );
});

it('validates uppercase rule successfully', function () {

    $validator = new Validator(['field' => 'lowercase'], ['field' => 'upper']);
    expect($validator->isValid())->toBeFalse();

    $validator = new Validator(['field' => 'UPPERCASE'], ['field' => 'upper']);
    expect($validator->isValid())->toBeTrue();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.uppercase_rule', [
            'attribute' => 'field',
        ])
    );
});

it('validates file rule successfully', function () {

    $validator = new Validator(['field' => __FILE__], ['field' => 'file']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 'nonexistentfile.txt'], ['field' => 'file']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.file_rule', [
            'attribute' => 'field',
        ])
    );
});

it('validates alpha_numeric rule successfully', function () {

    $validator = new Validator(['field' => 'alpha2324'], ['field' => 'alpha_numeric']);
    expect($validator->isValid())->toBeTrue();

    $validator = new Validator(['field' => 's$sdfde$*'], ['field' => 'alpha_numeric']);
    expect($validator->isValid())->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.alpha_numeric', [
            'attribute' => 'field',
        ])
    );
});

it('validates required_with rule successfully', function () {
    
    $validator = new RequiredWithRule(['other_field']);

    expect($validator->passes('field', 'value', ['other_field' => 'value2']))->toBeTrue();
    expect($validator->passes('field', 'value', []))->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.required_with', [
            'attribute' => 'field',
            'value' => 'other_field',
        ])
    );
});

it('validates boolean rule successfully', function () {
    $validator = new BooleanRule([]);

    expect($validator->passes('field', false, []))->toBeTrue();
    expect($validator->passes('field', 'string', []))->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.boolean', [
            'attribute' => 'field',
        ])
    );
});

it('validates json rule successfully', function () {
    $validator = new JsonRule([]);

    expect($validator->passes('field', "", []))->toBeFalse();
    expect($validator->passes('field', '{"name":"vishal", "email": "abc@gmail.com"}', []))->toBeTrue();
    expect($validator->passes('field', '{name:vishal, email: abc@gmail.com}', []))->toBeFalse();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.json', [
            'attribute' => 'field',
        ])
    );
});

it('validates url rule successfully', function () {
    $validator = new UrlRule([]);

    expect($validator->passes('field', "invalid_url", []))->toBeFalse();
    expect($validator->passes('field', 'http://google.com', []))->toBeTrue();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.url', [
            'attribute' => 'field',
        ])
    );
});

it('validates ip rule successfully', function () {
    $validator = new ValidIpRule([]);

    expect($validator->passes('field', "3853598", []))->toBeFalse();
    expect($validator->passes('field', '127.0.0.1', []))->toBeTrue();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.valid_ip', [
            'attribute' => 'field',
        ])
    );
});

it('validates size rule (string) successfully', function () {
    $validator = new SizeRule([4]);

    expect($validator->passes('field', "azerty", []))->toBeFalse();
    expect($validator->passes('field', 'azer', []))->toBeTrue();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.size', [
            'attribute' => 'field',
            'value' => 4,
        ])
    );
});

it('validates size rule (integer) successfully', function () {
    $validator = new SizeRule([3]);

    expect($validator->passes('field', 6, []))->toBeFalse();
    expect($validator->passes('field', 3, []))->toBeTrue();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.size', [
            'attribute' => 'field',
            'value' => 3,
        ])
    );
});

it('validates size rule (array) successfully', function () {
    $validator = new SizeRule([2]);

    expect($validator->passes('field', ['key1', 'key2', 'key3'], []))->toBeFalse();
    expect($validator->passes('field', ['key1', 'key2'], []))->toBeTrue();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.size', [
            'attribute' => 'field',
            'value' => 2,
        ])
    );
});

it('validates size rule (file) successfully', function () {
    $validator = new SizeRule([512]);

    expect($validator->passes('field', __FILE__, []))->toBeFalse();
    // expect($validator->passes('field', __FILE__, []))->toBeTrue();

    expect($validator->getErrors()['field'][0])->toBe(
        LangManager::getTranslation('validation.size', [
            'attribute' => 'field',
            'value' => 512,
        ])
    );
});
