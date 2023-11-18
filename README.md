<div align="center">

<img src="https://php-validator.kabirou-alassane.com/assets/logo/svg/logo-color.svg" alt="logo PHPValidator" width="600" height="200">

![Packagist Version (custom server)](https://img.shields.io/packagist/v/BlakvGhost/php-validator?label=stable)
![Packagist Version (custom server)](https://img.shields.io/packagist/l/BlakvGhost/php-validator?label=Licence)
![Packagist Version (custom server)](https://img.shields.io/packagist/dt/BlakvGhost/php-validator?label=download)

</div>


# About PHPValidator

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

try {

    $data = [
        'username' => 'BlakvGhost',
        'email' => 'example@example.com',
        'score' => 42,
    ];
    // or
    // $data = $_POST;

    $validator = new Validator($data, [
        'username' => 'required|string',
        'email' => 'required|email',
        'score' => ['required','max:200', new CustomRule()],
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
    'username' => 'max:25'
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
    'username' => 'lowercase'
    ```

13. **Uppercase Rule**
    - Validates that a field contains only uppercase alphabetic characters.

    ```php
    'username' => 'uppercase'
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
    'username' => 'min:8'
    ```	
19. **Not In Rule**
    - Validates that a field's value is not in a specified set.

    ```php
    'value' => 'not_in:["foo", "bar"]'
    ```	
20. **Required With Rule**
    - Requires the field to be present if another specified field is present.


    ```php
    'firstname' => 'required_with:lastname',
    ```	

21. **Valid IP Rule**
    - Validates that a field's value is a valid IP address.

    ```php
    'client_ip' => 'ip',
    ```

22. **Json Rule**
    - Validates that a field's value is a valid JSON string.

    ```php
    'config' => 'json',
    ```	

23. **URL Rule**
    - Validates that a field's value is a valid URL.

    ```php
    'website' => 'url',
    ```	
24. **Alpha Numeric Rule**

    - Validates that a field's value contains only alphanumeric characters.

    ```php
    'pseudo' => 'alpha_num',
    ```	

25. **Boolean Rule**

    - Validates that a field's value is a boolean.

    ```php
    'is_admin' => 'bool',
    ```	

26. **Size Rule**
    - Validates that the size of a string, integer, array, or file is equal to a specified value.

    ```php
        [
            'string' =>'size:7', // strlen(string) == 7
            'integer' =>'size:7', // integer == 7
            'array' =>'size:7', // count(array) == 7
            'file' =>'size:512', // file size (kb) == 512
        ]
    ```	
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

- Use your custom class directly

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
- Add your custom class to the rules list and use it as if it were native

    ```php

    use BlakvGhost\PHPValidator\Validator;
    use BlakvGhost\PHPValidator\ValidatorException;
    use BlakvGhost\PHPValidator\RulesMaped;
    use YourNameSpace\CustomPasswordRule;

    // Add your rule here using an alias and the full namespace of your custom class
    RulesMaped::addRule('c_password', CustomPasswordRule::class);

    try {

        $data = [
            'password' => '42',
            'confirm_password' => '142',
        ];

        $validator = new Validator($data, [
            'password' => 'required|c_password',
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

In this example, we created a CustomPasswordRule that checks if the password is equal to confirm_password. You can customize the passes method to implement your specific validation logic.

## Contributing

If you would like to contribute to PHPValidator, please follow our [Contribution Guidelines](CONTRIBUTING.md).

## Authors

- [Kabirou ALASSANE](https://github.com/BlakvGhost)


## Support

For support, you can reach out to me by email at <dev@kabirou-alassane.com>. Feel free to contact me if you have any questions or need assistance with PHPValidator.

## License

PHPValidator is open-source software licensed under the MIT license.

