<?php

/**
 * RulesMaped - Class that allows for easy reference and retrieval of validation rule classes.
 *
 * @package BlakvGhost\PHPValidator\Mapping
 * @author Kabirou ALASSANE
 * @website https://username-blakvghost.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Mapping;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\Lang\LangManager;
use BlakvGhost\PHPValidator\ValidatorException;

class RulesMaped
{
    use RulesAlias;

    /**
     * Get the mapping of rule aliases to their corresponding rule classes.
     *
     * @return array
     */
    protected static function getRules(): array
    {
        return self::$rules;
    }

    /**
     * Get the rule class for a given alias.
     *
     * @param string $alias Rule alias to retrieve the corresponding rule class.
     * @return string Rule class.
     * @throws ValidatorException If the rule alias is not found.
     */
    protected static function getRule(string $alias): string
    {
        if (isset(self::$rules[$alias]) && class_exists(self::$rules[$alias])) {
            return self::$rules[$alias];
        }

        $translatedMessage = LangManager::getTranslation('validation.rule_not_found', [
            'ruleName' => $alias,
        ]);

        throw new ValidatorException($translatedMessage);
    }

    /**
     * @param Rule|class-string<Rule> $rule
     */
    protected static function getAlias(Rule|string $rule): ?string
    {
        if (!is_string($rule)) {
            $rule = $rule::class;
        }
        $reversed = array_flip(self::$rules);

        return $reversed[$rule] ?? null;
    }

    /**
     * Add a new rule to the mapping.
     *
     * @param string $alias Rule alias.
     * @param string $className Rule class name.
     * @return void
     * @throws ValidatorException if the rule exists under a different alias
     */
    public static function addRule(string $alias, string $className): void
    {
        if ($key = array_search($className, self::$rules)) {
            $translatedMessage = LangManager::getTranslation('validation.rule_exists', [
                'ruleName' => $className,
                'alias' => $key,
            ]);

            throw new ValidatorException($translatedMessage);
        }

        self::$rules[$alias] = $className;
    }
}
