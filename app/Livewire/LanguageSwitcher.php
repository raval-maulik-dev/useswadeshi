<?php

namespace App\Livewire;

use App\LanguageHelper;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale = 'en';

    public array $availableLocales = [];

    public bool $showDropdown = false;

    public function mount(): void
    {
        $this->currentLocale = LanguageHelper::getCurrentLocale();
        $this->availableLocales = LanguageHelper::getAvailableLocales();
    }

    public function toggleDropdown(): void
    {
        $this->showDropdown = ! $this->showDropdown;
    }

    public function switchLanguage(string $locale): void
    {
        if (array_key_exists($locale, $this->availableLocales)) {
            LanguageHelper::setLocale($locale);
            $this->currentLocale = $locale;
            $this->showDropdown = false;

            // Redirect to refresh the page with new locale
            $this->redirect(request()->header('Referer'));
        }
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
