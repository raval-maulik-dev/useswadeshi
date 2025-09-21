<?php

namespace App\Livewire\Pages;

use App\GameLanguageHelper;
use App\Models\Game;
use Livewire\Component;
use Livewire\WithPagination;

class MultiLanguageGames extends Component
{
    use WithPagination;

    public string $selectedLanguage = 'en';

    public array $availableLanguages = [];

    public $games = [];

    public function mount(): void
    {
        $this->selectedLanguage = app()->getLocale();
        $this->availableLanguages = GameLanguageHelper::getAvailableGameLanguages();
        $this->loadGames();
    }

    public function switchLanguage(string $language): void
    {
        if (array_key_exists($language, $this->availableLanguages)) {
            $this->selectedLanguage = $language;
            app()->setLocale($language);
            session(['locale' => $language]);
            $this->loadGames();
        }
    }

    public function loadGames(): void
    {
        $this->games = Game::active()
            ->where(function ($query) {
                $query->where('locale', $this->selectedLanguage)
                    ->orWhere('locale', 'en'); // Fallback to English
            })
            ->orderBy('locale', 'desc') // Prefer current locale over English
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getLocalizedGameName(Game $game): string
    {
        return $game->localized_name;
    }

    public function getLocalizedGameDescription(Game $game): ?string
    {
        return $game->localized_description;
    }

    public function hasGameTranslations(Game $game): bool
    {
        return GameLanguageHelper::hasGameTranslations($game);
    }

    public function getTranslationStatus(Game $game): array
    {
        return GameLanguageHelper::getGameTranslationStatus($game);
    }

    public function render()
    {
        return view('livewire.pages.multi-language-games', [
            'games' => $this->games,
            'selectedLanguage' => $this->selectedLanguage,
            'availableLanguages' => $this->availableLanguages,
        ]);
    }
}
