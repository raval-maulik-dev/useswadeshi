<?php

namespace App;

class LanguageHelper
{
    /**
     * Get available locales
     */
    public static function getAvailableLocales(): array
    {
        return config('app.available_locales', [
            'en' => 'English',
            'hi' => 'हिंदी',
            'gu' => 'ગુજરાતી',
        ]);
    }

    /**
     * Get current locale
     */
    public static function getCurrentLocale(): string
    {
        return app()->getLocale();
    }

    /**
     * Set locale
     */
    public static function setLocale(string $locale): void
    {
        if (array_key_exists($locale, self::getAvailableLocales())) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        }
    }

    /**
     * Get locale name by code
     */
    public static function getLocaleName(string $locale): string
    {
        $locales = self::getAvailableLocales();

        return $locales[$locale] ?? $locale;
    }

    /**
     * Check if locale is RTL
     */
    public static function isRTL(string $locale): bool
    {
        // Add RTL languages here if needed in the future
        $rtlLocales = [];

        return in_array($locale, $rtlLocales);
    }
}
