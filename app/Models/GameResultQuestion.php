<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameResultQuestion extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'game_result_id',
        'question_id',
        'question_text',
        'points',
        'is_correct',
        'earned_points',
        'time_taken',
    ];

    public function result(): BelongsTo
    {
        return $this->belongsTo(GameResult::class, 'game_result_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(GameQuestion::class, 'question_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(GameResultAnswer::class, 'game_result_question_id');
    }
}
