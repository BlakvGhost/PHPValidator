# PHPValidator

PHPValidator is a modern PHP library for data validation in your PHP applications. It provides a flexible and extensible way to validate data using predefined rules or by creating custom validation rules.

![Packagist Version (custom server)](https://img.shields.io/packagist/v/Blakvghost/php-validator?label=stable)
![Packagist Version (custom server)](https://img.shields.io/packagist/l/Blakvghost/php-validator?label=Licence)
![Packagist Version (custom server)](https://img.shields.io/packagist/dt/Blakvghost/php-validator?label=download)

## Installation

Use [Composer](https://getcomposer.org/) to install PHPValidator:

```bash
composer require blakvghost/php-validator
```

## Usage

```php
use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;

try {

    $data = [
        'username' => 'BlakvGhost',
        'email' => 'example@example.com',
        'score' => 42,
    ];
    // or
    // $data = $_POST;

    $validator = new Validator($data, [
        'username' => 'required|string:25',
        'email' => 'required|email',
        'score' => ['required','max_length:200', new CustomRule()],
        'password' => new CustomRule(),
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


## List of Predefined Rules

PHPValidator provides a variety of predefined rules that you can use for data validation. Here is a list of some commonly used rules along with examples of their usage:

1. **Required Rule**
    - Ensures that a field is present in the data.

    ```php
    'username' => 'required'
    ```

2. **String Rule**
    - Checks if a field is of string type.

    ```php
    'username' => 'string'
    ```

3. **Email Rule**
    - Validates that a field is a well-formed email address.

    ```php
    'email' => 'email'
    ```

4. **Max Length Rule**
    - Specifies the maximum length of a string field.

    ```php
    'username' => 'max_length:25'
    ```

5. **Confirmed Rule**
    - Checks if a field's value is the same as another field (commonly used for password confirmation).

    ```php
    'password_confirmation' => 'confirmed:password'
    ```

6. **File Rule**
    - Validates that a field is a file upload.

    ```php
    'file' => 'file'
    ```

7. **Accepted Rule**
    - Validates that a field is `"yes"`, `"on"`, `"1"`, or `true`. Useful for checkboxes.

    ```php
    'terms_and_conditions' => 'accepted'
    ```

8. **Accepted If Rule**
    - Validates that a field is accepted if another field is equal to a specified value.

    ```php
    'terms_and_conditions' => 'accepted_if:is_adult,true'
    ```

9. **ActiveURL Rule**
    - Validates that a field is a valid, active URL.

    ```php
    'website' => 'active_url'
    ```

10. **Alpha Rule**
    - Validates that a field contains only alphabetic characters.

    ```php
    'name' => 'alpha'
    ```

11. **Numeric Rule**
    - Validates that a field contains only numeric characters.

    ```php
    'age' => 'numeric'
    ```

12. **Lowercase Rule**
    - Validates that a field contains only lowercase alphabetic characters.

    ```php
    'username' => 'lower'
    ```

13. **Uppercase Rule**
    - Validates that a field contains only uppercase alphabetic characters.

    ```php
    'username' => 'upper'
    ```

14. **In Rule**
    - Validates that a field's value is among a list of predefined values.

    ```php
    'role' => 'in:admin,editor,viewer'
    ```

15. **Nullable Rule**
    - Allows a field to be `null` or empty.

    ```php
    'optional_field' => 'nullable'
    ```

16. **Password Rule**
    - Validates that a field is a `secure password`.

    ```php
    'password' => 'password'
    ```

17. **Same Rule**
    - Validates that a field's value is the same as the value of another field.

    ```php
    'password_confirmation' => 'same:password'
    ```
18. **Max Length Rule**
    - Specifies the minimum length of a string field.

    ```php
    'username' => 'min_length:8'
  

## Custom Rule

In addition to the predefined rules, you can create custom validation rules by implementing the `RuleInterface`. Here's an example of how to create and use a custom rule:

### CustomPasswordRule.php

```php
// CustomPasswordRule.php
namespace YourNameSpace\Rules;

use BlakvGhost\PHPValidator\Rules\RuleInterface;
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
use BlakvGhost\PHPValidator\ValidatorException;
use YourNameSpace\CustomPasswordRule;


// ...

try {

    $data = [
        'password' => '42',
        'confirm_password' => '142',
    ];
    // or
    // $data = $_POST;

    $validator = new Validator($data, [
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
In this example, we created a CustomRule that checks if the password is equal to confirm_password. You can customize the passes method to implement your specific validation logic.

## Contributing

If you would like to contribute to PHPValidator, please follow our [Contribution Guidelines](CONTRIBUTING.md).

## Authors

- [Kabirou ALASSANE](https://github.com/BlakvGhost)


## Support

For support, you can reach out to me by email at <dev@kabirou-alassane.com>. Feel free to contact me if you have any questions or need assistance with PHPValidator.

## License

PHPValidator is open-source software licensed under the MIT license.

