<p align="center">
  
![PHPValidator Logo (Dark)](https://php-validator.ferraydigitalsolutions.bj/assets/logo/svg/logo-no-background1.svg)

![PHPValidator Logo (Light)](https://php-validator.ferraydigitalsolutions.bj/assets/logo/png/logo-color1.png)

[![Packagist Version](https://img.shields.io/packagist/v/BlakvGhost/php-validator?label=stable)](https://packagist.org/packages/blakvghost/php-validator)
[![License](https://img.shields.io/packagist/l/BlakvGhost/php-validator?label=Licence)](https://packagist.org/packages/blakvghost/php-validator)
[![Downloads](https://img.shields.io/packagist/dt/BlakvGhost/php-validator?label=download)](https://packagist.org/packages/blakvghost/php-validator)

</p>

## About PHPValidator

A modern PHP library for data validation in your applications. PHPValidator provides a flexible and extensible approach to validating data using predefined rules or by creating custom validation rules.

---

## Installation

Install PHPValidator via Composer:

```bash
composer require blakvghost/php-validator
```

---

## Quick Start

```php
use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;

try {
    $data = [
        'username' => 'BlakvGhost',
        'email' => 'example@example.com',
        'score' => 42,
        'tags' => [
            ['name' => 'php'],
            ['name' => 'validation'],
        ],
        'friend' => [
            'email' => 'test@example.com',
            'profile' => [
                'first_name' => 'Kabirou',
            ],
        ],
    ];

    $validator = new Validator($data, [
        'username' => 'required|string',
        'email' => 'required|email',
        'tags.*.name' => 'required|string',
        'score' => ['required', 'max:200', new CustomRule()],
        'password' => new CustomRule(),
        'friend.profile.first_name' => 'required|string',
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

---

## Customize Messages

You can customize error messages or specify the default language:

```php
$data = ['username' => 'BlakvGhost'];

$validator = new Validator(
    $data,
    ['username' => 'required|string'],
    [
        'username' => [
            'required' => 'Your username must be present',
            'string' => 'Your username must be a string',
        ],
    ]
);

// Or set the default language
$validator = new Validator($data, $rules, lang: 'en');
```

---

## Nested and Wildcard Notation

PHPValidator supports dot notation for validating deeply nested fields, as well as wildcard notation (`*`) to apply rules across arrays of data.

### Nested Keys

Validate nested fields using dot notation:

```php
$data = [
    'user' => [
        'profile' => [
            'first_name' => 'Kabirou',
        ]
    ]
];

$rules = [
    'user.profile.first_name' => 'required|string',
];
```

### Wildcard Notation

Use `*` as a wildcard to apply the same rule to all elements of an array:

```php
$data = [
    'products' => [
        ['name' => 'Banana'],
        ['name' => 'Apple'],
    ]
];

$rules = [
    'products.*.name' => 'required|string',
];
```

---

## Key Features

- **Predefined Rules** : A comprehensive set of ready-to-use validation rules (required, string, email, maxLength, etc.)
- **Custom Rules** : Easily create your own validation rules by implementing the `Rule` interface
- **Multilingual Support** : Customize error messages according to your application's language
- **Nested Validation** : Validate complex data structures with dot notation
- **Wildcard Notation** : Apply rules to all elements in an array

---

## Predefined Rules

### Basic Validation

| Rule | Example | Description |
|------|---------|-------------|
| `required` | `'username' => 'required'` | Ensures the field is present in the data |
| `string` | `'username' => 'string'` | Checks if the field is of string type |
| `nullable` | `'optional_field' => 'nullable'` | Allows the field to be null or empty |
| `not_nullable` | `'optional_field' => 'not_nullable'` | The field must not be null or empty |

### Text Validation

| Rule | Example | Description |
|------|---------|-------------|
| `email` | `'email' => 'email'` | Validates a well-formed email address |
| `alpha` | `'name' => 'alpha'` | Contains only alphabetic characters |
| `numeric` | `'age' => 'numeric'` | Contains only numeric characters |
| `alpha_num` | `'pseudo' => 'alpha_num'` | Contains only alphanumeric characters |
| `lowercase` | `'username' => 'lowercase'` | Contains only lowercase alphabetic characters |
| `uppercase` | `'username' => 'uppercase'` | Contains only uppercase alphabetic characters |

### Length Validation

| Rule | Example | Description |
|------|---------|-------------|
| `min` | `'username' => 'min:8'` | Minimum length of a string |
| `max` | `'username' => 'max:25'` | Maximum length of a string |
| `size` | `'string' => 'size:7'` | Exact size of a string, integer, array, or file |

**Size Rule Examples:**

```php
[
    'string' => 'size:7',          // strlen(string) == 7
    'integer' => 'size:7',         // integer == 7
    'array' => 'size:7',           // count(array) == 7
    'file' => 'size:512',          // file size (kb) == 512
]
```

### Comparison Validation

| Rule | Example | Description |
|------|---------|-------------|
| `in` | `'role' => 'in:admin,editor,viewer'` | Value must be in a predefined list |
| `not_in` | `'value' => 'not_in:foo,bar'` | Value must not be in the specified list |
| `same` | `'password_confirmation' => 'same:password'` | Field value equals another field's value |
| `confirmed` | `'password_confirmation' => 'confirmed:password'` | Field matches another field (for confirmation) |

### Security Validation

| Rule | Example | Description |
|------|---------|-------------|
| `password` | `'password' => 'password'` | Validates a secure password |

### File and URL Validation

| Rule | Example | Description |
|------|---------|-------------|
| `file` | `'file' => 'file'` | Validates that a field is a file upload |
| `url` | `'website' => 'url'` | Validates that a field is a valid URL |
| `active_url` | `'website' => 'active_url'` | Validates that a field is a valid, active URL |

### Format Validation

| Rule | Example | Description |
|------|---------|-------------|
| `bool` | `'is_admin' => 'bool'` | Validates that a field is a boolean |
| `ip` | `'client_ip' => 'ip'` | Validates that a field is a valid IP address |
| `json` | `'config' => 'json'` | Validates that a field is a valid JSON string |

### Conditional Validation

| Rule | Example | Description |
|------|---------|-------------|
| `accepted` | `'terms_and_conditions' => 'accepted'` | Field is "yes", "on", "1", or true (useful for checkboxes) |
| `accepted_if` | `'terms_and_conditions' => 'accepted_if:is_adult,true'` | Field is accepted if another field equals a value |
| `required_with` | `'firstname' => 'required_with:lastname'` | Field is required if another field is present |
| `not_required_with` | `'email' => 'not_required_with:phone_number'` | Field must not be present if another field is present |

---

## Extract Validated Data

The `validated()` method returns only fields that:

- have validation rules
- passed validation successfully

```php
$data = [
    'name' => 'John',
    'age' => 30,
    'extra_field' => 'ignored'
];

$validator = new Validator($data, [
    'name' => 'required',
    'age' => 'required',
]);

$validated = $validator->validated();

// Result:
[
    'name' => 'John',
    'age' => 30
]
```

---

## Create Custom Rules

Beyond predefined rules, you can create your own validation rules by implementing the `Rule` interface.

### Example: CustomPasswordRule.php

```php
namespace YourNameSpace\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;

class CustomPasswordRule implements Rule
{
    protected $field;

    public function __construct(protected array $parameters = [])
    {
    }

    public function passes(string $field, $value, array $data): bool
    {
        $this->field = $field;
        // Implement your custom validation logic here
        // Example: Check if the password equals confirm_password
        return $value === $data['confirm_password'];
    }

    public function message(): string
    {
        return "Your passwords do not match";
    }
}
```

### Usage in Validator

**Method 1: Use your class directly**

```php
use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;
use YourNameSpace\CustomPasswordRule;

try {
    $data = [
        'password' => '42',
        'confirm_password' => '142',
    ];

    $validator = new Validator($data, [
        'password' => ['required', new CustomPasswordRule()],
    ]);

    if ($validator->isValid()) {
        echo "Validation passed!";
    } else {
        print_r($validator->getErrors());
    }
} catch (ValidatorException $e) {
    echo "Error: " . $e->getMessage();
}
```

**Method 2: Add to the rules list and use as a native rule**

```php
use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;
use BlakvGhost\PHPValidator\Mapping\RulesMaped;
use YourNameSpace\CustomPasswordRule;

// Add your rule with an alias and the full namespace
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
        print_r($validator->getErrors());
    }
} catch (ValidatorException $e) {
    echo "Error: " . $e->getMessage();
}
```

---

## Testing

PHPValidator is fully tested using [PestPHP](https://pestphp.com/).

Run all tests:

```bash
composer test
```

Or manually:

```bash
./vendor/bin/pest
```

Tests are located in the `/tests/Feature` directory and include examples for:

- `nullable` and `not_nullable` rules
- `validated()` behavior
- Nested and wildcard validations

---

## Contributing

If you would like to contribute to PHPValidator, please follow our [Contribution Guidelines](CONTRIBUTING.md).

---

## Author

**Kabirou ALASSANE** - [GitHub](https://github.com/BlakvGhost)

---

## Support

For questions or assistance with PHPValidator, you can contact me at [https://kabiroualassane.link](https://kabiroualassane.link).

---

## License

PHPValidator is open-source software licensed under the MIT license.
