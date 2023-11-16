# PHPValidator

PHPValidator is a modern PHP library for data validation in your PHP applications. It provides a flexible and extensible way to validate data using predefined rules or by creating custom validation rules.

## Installation

Use [Composer](https://getcomposer.org/) to install PHPValidator:

```bash
composer require blakvghost/php-validator
```

## Usage

```php
use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;
use BlakvGhost\PHPValidator\LangManager;
use BlakvGhost\PHPValidator\Rules\EmailRule;

try {
    $validator = new Validator([
        'username' => 'BlakvGhost',
        'email' => 'example@example.com',
        'score' => 42,
    ], [
        'username' => 'required|string:25',
        'email' => 'required|email',
        'score' => ['required','max_length:200', new CustomRule()],
    ]);

    if ($validator->isValid()) {
        echo "Validation passed!";
    } else {
        $errors = $validator->getErrors();
        print_r($errors);
    }
} catch (ValidatorException $e) {
    echo "Validation error: " . $e->getMessage();
}

```

## Features

- `Predefined Rules`: PHPValidator comes with a set of predefined validation rules such as required, string, email, maxLength etc.

- `Custom Rules`: Easily create custom validation rules by implementing the `RuleInterface`.

- `Multilingual Support`: Customize validation error messages based on the application's language using the `LangManager`.

## Custom Rule

In addition to the predefined rules, you can create custom validation rules by implementing the `RuleInterface`. Here's an example of how to create and use a custom rule:

### CustomRule.php

```php
// CustomPasswordRule.php
namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\LangManager;

class CustomPasswordRule implements RuleInterface
{
    protected $field;

    public function __construct(protected array $parameters = [])
    {
    }

    public function passes(string $field, $value, array $data): bool
    {
        $this->field = $field;
        // Implement your custom validation logic here
        // Example: Check if the password is equal to confirm_password
        return $value === $data['confirm_password'];
    }

    public function message(): string
    {
        return "Vos deux mot de passes ne sont pas identiques";
    }
}
```
### Usage in Validator

```php

use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\Rules\CustomPasswordRule;

// ...

try {
    $validator = new Validator([
        'password' => '42',
        'confirm_password' => '142',
    ], [
        'password' => ['required', new CustomPasswordRule()],
    ]);

    if ($validator->isValid()) {
        echo "Validation passed!";
    } else {
        $errors = $validator->getErrors();
        print_r($errors);
    }
} catch (ValidatorException $e) {
    echo "Validation error: " . $e->getMessage();
}
```
In this example, we created a CustomRule that checks if a given value is greater than a specified parameter. You can customize the passes method to implement your specific validation logic.

## Contributing

If you would like to contribute to PHPValidator, please follow our [Contribution Guidelines](CONTRIBUTING.md).

## License

PHPValidator is open-source software licensed under the MIT license.

