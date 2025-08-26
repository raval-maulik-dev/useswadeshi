<?php

use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Pages\Home::class)->name('home');

Route::get('login', \App\Livewire\Pages\Login::class)->name('login');

// Logout Route
Route::post('logout', function () {
    auth()->logout();

    return redirect()->route('home')->with('success', 'You have been logged out successfully.');
})->name('logout');

// Quiz Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/quiz', \App\Livewire\Pages\Quiz::class)->name('quiz');
    Route::get('/quiz/start/{game}', \App\Livewire\Pages\QuizStart::class)->name('quiz.start');
    Route::get('/quiz/result/{result}', \App\Livewire\Pages\QuizResult::class)->name('quiz.result');

    // User Profile Routes
    Route::get('/profile', \App\Livewire\Pages\UserProfile::class)->name('user.profile');

    // Certificate Routes
    Route::get('/certificate/download/{result}', function ($result) {
        // This would handle certificate download
        return response()->json(['message' => 'Certificate download initiated']);
    })->name('certificate.download');

    Route::get('/certificate/share/{result}', function ($result) {
        // This would handle certificate sharing
        return response()->json(['message' => 'Certificate share initiated']);
    })->name('certificate.share');
});

// Public Routes
Route::get('/leaderboard', \App\Livewire\Pages\Leaderboard::class)->name('leaderboard');
Route::get('/products', \App\Livewire\Pages\Products::class)->name('products');
Route::get('/vendors', \App\Livewire\Pages\Vendors::class)->name('vendors');
Route::get('/articles', \App\Livewire\Pages\Articles::class)->name('articles');
Route::get('/articles/{article}', \App\Livewire\Pages\ArticleDetail::class)->name('articles.show');

// Pledge Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/pledges', \App\Livewire\Pages\Pledges::class)->name('pledges');
    Route::get('/dashboard', \App\Livewire\Pages\Dashboard::class)->name('dashboard');
});

// Authentication Routes
// Auth::routes();

// Quiz Routes (commented out for now)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
// });

// Leaderboard Route (commented out for now)
// Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
