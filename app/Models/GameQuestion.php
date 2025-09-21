<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameQuestion extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'game_id',
        'question',
        'question_hi',
        'question_gu',
        'type',
        'difficulty',
        'points',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'points' => 'integer',
    ];

    /**
     * Get the localized question text based on current locale
     */
    public function getLocalizedQuestionAttribute(): string
    {
        $locale = app()->getLocale();

        return match ($locale) {
            'hi' => $this->question_hi ?? $this->question,
            'gu' => $this->question_gu ?? $this->question,
            default => $this->question,
        };
    }

    /**
     * Get the game that owns the question.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the options for the question.
     */
    public function options(): HasMany
    {
        return $this->hasMany(GameOption::class, 'question_id')->ordered();
    }

    /**
     * Get the correct options for the question.
     */
    public function correctOptions(): HasMany
    {
        return $this->hasMany(GameOption::class, 'question_id')->correct()->ordered();
    }

    /**
     * Get the incorrect options for the question.
     */
    public function incorrectOptions(): HasMany
    {
        return $this->hasMany(GameOption::class, 'question_id')->incorrect()->ordered();
    }

    /**
     * Check if this is a single answer question.
     */
    public function isSingleAnswer(): bool
    {
        return in_array($this->type, ['mcq', 'true_false']);
    }

    /**
     * Check if this is a multiple answer question.
     */
    public function isMultipleAnswer(): bool
    {
        return $this->type === 'multi_select';
    }

    /**
     * Get the total number of correct options.
     */
    public function getCorrectOptionsCountAttribute(): int
    {
        return $this->correctOptions()->count();
    }

    /**
     * Get the total number of options.
     */
    public function getOptionsCountAttribute(): int
    {
        return $this->options()->count();
    }

    /**
     * Check if the question has the minimum required options.
     */
    public function hasMinimumOptions(): bool
    {
        return $this->options_count >= 2;
    }

    /**
     * Check if the question has at least one correct option.
     */
    public function hasCorrectOption(): bool
    {
        return $this->correct_options_count > 0;
    }

    /**
     * Get the question type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'mcq' => 'Multiple Choice (Single Answer)',
            'multi_select' => 'Multiple Choice (Multiple Answers)',
            'true_false' => 'True/False',
            default => 'Unknown',
        };
    }

    /**
     * Get the difficulty label.
     */
    public function getDifficultyLabelAttribute(): string
    {
        return match ($this->difficulty) {
            'easy' => 'Easy',
            'medium' => 'Medium',
            'hard' => 'Hard',
            default => 'Unknown',
        };
    }
}
