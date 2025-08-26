<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'total_questions',
        'per_question_time',
        'allow_replay',
        'show_correct_answers',
        'is_active',
        'max_attempts',
        'certificate_template',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'allow_replay' => 'boolean',
        'show_correct_answers' => 'boolean',
        'is_active' => 'boolean',
        'certificate_template' => 'array',
    ];

    /**
     * Get the game questions for the game.
     */
    public function gameQuestions(): HasMany
    {
        return $this->hasMany(GameQuestion::class);
    }

    /**
     * Get the game results for the game.
     */
    public function gameResults(): HasMany
    {
        return $this->hasMany(GameResult::class);
    }

    /**
     * Get active games only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get questions for this game based on configuration.
     */
    public function getQuestionsForGame()
    {
        $questions = $this->gameQuestions;

        if ($this->total_questions && $this->total_questions < $questions->count()) {
            return $questions->shuffle()->take($this->total_questions);
        }

        return $questions->shuffle();
    }

    /**
     * Check if user can play this game.
     */
    public function canUserPlay($userId): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if (! $this->allow_replay) {
            $hasPlayed = $this->gameResults()->where('user_id', $userId)->exists();
            if ($hasPlayed) {
                return false;
            }
        }

        if ($this->max_attempts) {
            $attempts = $this->gameResults()->where('user_id', $userId)->count();
            if ($attempts >= $this->max_attempts) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get user's attempt number for this game.
     */
    public function getUserAttemptNumber($userId): int
    {
        return $this->gameResults()->where('user_id', $userId)->count() + 1;
    }

    /**
     * Get user's best result for this game.
     */
    public function getUserBestResult($userId)
    {
        return $this->gameResults()
            ->where('user_id', $userId)
            ->orderBy('total_points', 'desc')
            ->orderBy('accuracy_percentage', 'desc')
            ->first();
    }

    /**
     * Get user's result history for this game.
     */
    public function getUserResultHistory($userId)
    {
        return $this->gameResults()
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
