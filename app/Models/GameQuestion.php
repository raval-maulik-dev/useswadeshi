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
        return $this->hasMany(GameOption::class, 'question_id')->orderBy('sort_order');
    }

    /**
     * Get the correct options for the question.
     */
    public function correctOptions(): HasMany
    {
        return $this->hasMany(GameOption::class, 'question_id')->where('is_correct', true);
    }

    /**
     * Get the incorrect options for the question.
     */
    public function incorrectOptions(): HasMany
    {
        return $this->hasMany(GameOption::class, 'question_id')->where('is_correct', false);
    }
}
