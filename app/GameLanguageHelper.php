<?php

namespace App;

use App\Models\Game;
use App\Models\GameOption;
use App\Models\GameQuestion;

class GameLanguageHelper
{
    /**
     * Get available game languages
     */
    public static function getAvailableGameLanguages(): array
    {
        return [
            'en' => 'English',
            'hi' => 'हिंदी',
            'gu' => 'ગુજરાતી',
        ];
    }

    /**
     * Get current game language
     */
    public static function getCurrentGameLanguage(): string
    {
        return app()->getLocale();
    }

    /**
     * Set game language
     */
    public static function setGameLanguage(string $language): void
    {
        if (array_key_exists($language, self::getAvailableGameLanguages())) {
            app()->setLocale($language);
            session(['game_language' => $language]);
        }
    }

    /**
     * Get localized game content
     */
    public static function getLocalizedGameContent(Game $game): array
    {
        $locale = self::getCurrentGameLanguage();

        return [
            'name' => $game->localized_name,
            'description' => $game->localized_description,
            'locale' => $locale,
        ];
    }

    /**
     * Get localized question content
     */
    public static function getLocalizedQuestionContent(GameQuestion $question): array
    {
        $locale = self::getCurrentGameLanguage();

        return [
            'question' => $question->localized_question,
            'locale' => $locale,
        ];
    }

    /**
     * Get localized option content
     */
    public static function getLocalizedOptionContent(GameOption $option): array
    {
        $locale = self::getCurrentGameLanguage();

        return [
            'option_text' => $option->localized_option_text,
            'display_text' => $option->display_text,
            'locale' => $locale,
        ];
    }

    /**
     * Check if game has translations for current locale
     */
    public static function hasGameTranslations(Game $game): bool
    {
        $locale = self::getCurrentGameLanguage();

        if ($locale === 'en') {
            return true; // English is always available
        }

        return match ($locale) {
            'hi' => ! empty($game->name_hi) || ! empty($game->description_hi),
            'gu' => ! empty($game->name_gu) || ! empty($game->description_gu),
            default => false,
        };
    }

    /**
     * Check if question has translations for current locale
     */
    public static function hasQuestionTranslations(GameQuestion $question): bool
    {
        $locale = self::getCurrentGameLanguage();

        if ($locale === 'en') {
            return true; // English is always available
        }

        return match ($locale) {
            'hi' => ! empty($question->question_hi),
            'gu' => ! empty($question->question_gu),
            default => false,
        };
    }

    /**
     * Check if option has translations for current locale
     */
    public static function hasOptionTranslations(GameOption $option): bool
    {
        $locale = self::getCurrentGameLanguage();

        if ($locale === 'en') {
            return true; // English is always available
        }

        return match ($locale) {
            'hi' => ! empty($option->option_text_hi),
            'gu' => ! empty($option->option_text_gu),
            default => false,
        };
    }

    /**
     * Get games for current locale
     */
    public static function getGamesForCurrentLocale()
    {
        $locale = self::getCurrentGameLanguage();

        return Game::active()
            ->where(function ($query) use ($locale) {
                $query->where('locale', $locale)
                    ->orWhere('locale', 'en'); // Fallback to English
            })
            ->orderBy('locale', 'desc') // Prefer current locale over English
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get translation status for a game
     */
    public static function getGameTranslationStatus(Game $game): array
    {
        $status = [
            'en' => [
                'name' => ! empty($game->name),
                'description' => ! empty($game->description),
            ],
            'hi' => [
                'name' => ! empty($game->name_hi),
                'description' => ! empty($game->description_hi),
            ],
            'gu' => [
                'name' => ! empty($game->name_gu),
                'description' => ! empty($game->description_gu),
            ],
        ];

        // Calculate completion percentage for each language
        foreach ($status as $lang => &$fields) {
            $fields['completion'] = count(array_filter($fields)) / count($fields) * 100;
        }

        return $status;
    }

    /**
     * Get translation status for a question
     */
    public static function getQuestionTranslationStatus(GameQuestion $question): array
    {
        $status = [
            'en' => ! empty($question->question),
            'hi' => ! empty($question->question_hi),
            'gu' => ! empty($question->question_gu),
        ];

        return $status;
    }

    /**
     * Get translation status for an option
     */
    public static function getOptionTranslationStatus(GameOption $option): array
    {
        $status = [
            'en' => ! empty($option->option_text),
            'hi' => ! empty($option->option_text_hi),
            'gu' => ! empty($option->option_text_gu),
        ];

        return $status;
    }
}




