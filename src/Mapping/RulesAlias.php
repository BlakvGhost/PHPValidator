<?php

/**
 * RulesAlias - Class that maps all the validation rules with their aliases
 *
 * This class provides a convenient mapping of rule aliases to their corresponding PHPValidator rules.
 *
 * @package BlakvGhost\PHPValidator\Mapping
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Mapping;

use BlakvGhost\PHPValidator\Rules\AcceptedIfRule;
use BlakvGhost\PHPValidator\Rules\AcceptedRule;
use BlakvGhost\PHPValidator\Rules\ActiveURLRule;
use BlakvGhost\PHPValidator\Rules\AlphaNumericRule;
use BlakvGhost\PHPValidator\Rules\AlphaRule;
use BlakvGhost\PHPValidator\Rules\BooleanRule;
use BlakvGhost\PHPValidator\Rules\ConfirmedRule;
use BlakvGhost\PHPValidator\Rules\EmailRule;
use BlakvGhost\PHPValidator\Rules\FileRule;
use BlakvGhost\PHPValidator\Rules\InRule;
use BlakvGhost\PHPValidator\Rules\JsonRule;
use BlakvGhost\PHPValidator\Rules\LowerCaseRule;
use BlakvGhost\PHPValidator\Rules\MaxLengthRule;
use BlakvGhost\PHPValidator\Rules\MinLengthRule;
use BlakvGhost\PHPValidator\Rules\NotInRule;
use BlakvGhost\PHPValidator\Rules\NullableRule;
use BlakvGhost\PHPValidator\Rules\NumericRule;
use BlakvGhost\PHPValidator\Rules\PasswordRule;
use BlakvGhost\PHPValidator\Rules\RequiredRule;
use BlakvGhost\PHPValidator\Rules\RequiredWithRule;
use BlakvGhost\PHPValidator\Rules\NotRequiredWithRule;
use BlakvGhost\PHPValidator\Rules\SameRule;
use BlakvGhost\PHPValidator\Rules\SizeRule;
use BlakvGhost\PHPValidator\Rules\StringRule;
use BlakvGhost\PHPValidator\Rules\UpperCaseRule;
use BlakvGhost\PHPValidator\Rules\UrlRule;
use BlakvGhost\PHPValidator\Rules\ValidIpRule;

trait RulesAlias
{
    /**
     * @var array Mapping of rule aliases to their corresponding rule classes.
     */
    private static $rules = [
        'accepted' => AcceptedRule::class,
        'accepted_if' => AcceptedIfRule::class,
        'active_url' => ActiveURLRule::class,
        'alpha' => AlphaRule::class,
        'alpha_num' => AlphaNumericRule::class,
        'bool' => BooleanRule::class,
        'confirmed' => ConfirmedRule::class,
        'email' => EmailRule::class,
        'file' => FileRule::class,
        'in' => InRule::class,
        'not_in' => NotInRule::class,
        'string' => StringRule::class,
        'required' => RequiredRule::class,
        'required_with' => RequiredWithRule::class,
        'not_required_with' => NotRequiredWithRule::class,
        'lowercase' => LowerCaseRule::class,
        'uppercase' => UpperCaseRule::class,
        'json' => JsonRule::class,
        'max' => MaxLengthRule::class,
        'min' => MinLengthRule::class,
        'nullable' => NullableRule::class,
        'numeric' => NumericRule::class,
        'password' => PasswordRule::class,
        'same' => SameRule::class,
        'size' => SizeRule::class,
        'url' => UrlRule::class,
        'ip' => ValidIpRule::class,
    ];
}
