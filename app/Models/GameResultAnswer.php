<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameResultAnswer extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'game_result_question_id',
        'option_id',
        'option_text',
        'is_correct_option',
        'selected',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'selected' => 'boolean',
        'is_correct_option' => 'boolean',
    ];

    public function resultQuestion(): BelongsTo
    {
        return $this->belongsTo(GameResultQuestion::class, 'game_result_question_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(GameOption::class, 'option_id');
    }
}
