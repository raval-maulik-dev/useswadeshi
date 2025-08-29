<?php

namespace App\Http\Middleware;

use App\LanguageHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is set in session
        if (session()->has('locale')) {
            LanguageHelper::setLocale(session('locale'));
        } else {
            // Check if locale is in URL parameter
            $locale = $request->get('lang');
            if ($locale && array_key_exists($locale, LanguageHelper::getAvailableLocales())) {
                LanguageHelper::setLocale($locale);
            } else {
                // Set default locale
                LanguageHelper::setLocale('en');
            }
        }

        return $next($request);
    }
}
