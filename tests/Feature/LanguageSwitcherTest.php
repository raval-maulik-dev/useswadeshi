<?php

namespace Tests\Feature;

use App\LanguageHelper;
use App\Livewire\LanguageSwitcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LanguageSwitcherTest extends TestCase
{
    use RefreshDatabase;

    public function test_language_switcher_component_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeLivewire('language-switcher');
    }

    public function test_can_switch_to_hindi_language(): void
    {
        Livewire::test(LanguageSwitcher::class)
            ->assertSet('currentLocale', 'en')
            ->call('switchLanguage', 'hi')
            ->assertSet('currentLocale', 'hi');
    }

    public function test_can_switch_to_gujarati_language(): void
    {
        Livewire::test(LanguageSwitcher::class)
            ->assertSet('currentLocale', 'en')
            ->call('switchLanguage', 'gu')
            ->assertSet('currentLocale', 'gu');
    }

    public function test_can_switch_back_to_english(): void
    {
        Livewire::test(LanguageSwitcher::class)
            ->set('currentLocale', 'hi')
            ->call('switchLanguage', 'en')
            ->assertSet('currentLocale', 'en');
    }

    public function test_invalid_language_is_ignored(): void
    {
        Livewire::test(LanguageSwitcher::class)
            ->set('currentLocale', 'en')
            ->call('switchLanguage', 'invalid')
            ->assertSet('currentLocale', 'en');
    }

    public function test_language_helper_get_available_locales(): void
    {
        $locales = LanguageHelper::getAvailableLocales();

        $this->assertArrayHasKey('en', $locales);
        $this->assertArrayHasKey('hi', $locales);
        $this->assertArrayHasKey('gu', $locales);
        $this->assertEquals('English', $locales['en']);
        $this->assertEquals('हिंदी', $locales['hi']);
        $this->assertEquals('ગુજરાતી', $locales['gu']);
    }

    public function test_language_helper_set_locale(): void
    {
        LanguageHelper::setLocale('hi');
        $this->assertEquals('hi', app()->getLocale());
        $this->assertEquals('hi', session('locale'));
    }

    public function test_language_helper_get_current_locale(): void
    {
        app()->setLocale('gu');
        $this->assertEquals('gu', LanguageHelper::getCurrentLocale());
    }

    public function test_language_helper_get_locale_name(): void
    {
        $this->assertEquals('English', LanguageHelper::getLocaleName('en'));
        $this->assertEquals('हिंदी', LanguageHelper::getLocaleName('hi'));
        $this->assertEquals('ગુજરાતી', LanguageHelper::getLocaleName('gu'));
    }

    public function test_translations_are_loaded_correctly(): void
    {
        // Test English translations
        app()->setLocale('en');
        $this->assertEquals('Home', __('messages.home'));
        $this->assertEquals('Login', __('messages.login'));

        // Test Hindi translations
        app()->setLocale('hi');
        $this->assertEquals('होम', __('messages.home'));
        $this->assertEquals('लॉगिन', __('messages.login'));

        // Test Gujarati translations
        app()->setLocale('gu');
        $this->assertEquals('હોમ', __('messages.home'));
        $this->assertEquals('લૉગિન', __('messages.login'));
    }

    public function test_middleware_sets_locale_from_session(): void
    {
        session(['locale' => 'hi']);

        $response = $this->get('/');

        $this->assertEquals('hi', app()->getLocale());
    }

    public function test_middleware_sets_locale_from_url_parameter(): void
    {
        $response = $this->get('/?lang=gu');

        $this->assertEquals('gu', app()->getLocale());
        $this->assertEquals('gu', session('locale'));
    }
}
