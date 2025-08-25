<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
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
}
