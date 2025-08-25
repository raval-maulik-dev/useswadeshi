<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LeaderboardController;

Route::get('/', function () {
    // Static data for the welcome page
    $stats = [
        'total_participants' => 0,
        'quizzes_completed' => 0,
        'certificates_generated' => 0,
        'top_score' => 0,
        'average_score' => 0
    ];
    
    return view('welcome', compact('stats'));
})->name('home');

// Authentication Routes
Auth::routes();

// Quiz Routes (commented out for now)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
// });

// Leaderboard Route (commented out for now)
// Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
