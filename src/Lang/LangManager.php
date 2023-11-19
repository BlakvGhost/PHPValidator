<?php

/**
 * LangManager - A simple language manager for handling translations in the PHPValidator package.
 *
 * @package BlakvGhost\PHPValidator\Lang
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Lang;

class LangManager
{

    use Lang;

    /**
     * Get the current language.
     *
     * @return string Current language code.
     */
    private static function getLocal(): string
    {
        // Get the current language from environment variables, defaulting to 'en' (English) if not set.
        return $_ENV['local'] ?? 'en';
    }

    /**
     * Get a translated message for the given key.
     *
     * @param string $key Translation key.
     * @param array|null $parameters Placeholder values to replace in the translated message.
     * @return string Translated message.
     */
    public static function getTranslation(string $key, ?array $parameters = []): string
    {
        // Get the translation for the current language and the provided key, or use the key itself if not found.
        $translation = self::$translations[self::getLocal()][$key] ?? $key;

        // Replace placeholders in the translation with the provided values.
        if ($parameters) {
            foreach ($parameters as $placeholder => $value) {
                $translation = str_replace(":$placeholder", $value, $translation);
            }
        }

        return $translation;
    }
}
