<?php

/**
 * RulesMaped - Class that allows for easy reference and retrieval of validation rule classes.
 *
 * @package BlakvGhost\PHPValidator\Mapping
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Mapping;

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
     * Add a new rule to the mapping.
     *
     * @param string $alias Rule alias.
     * @param string $className Rule class name.
     * @return void
     */
    public static function addRule(string $alias, string $className): void
    {
        self::$rules[$alias] = $className;
    }
}
