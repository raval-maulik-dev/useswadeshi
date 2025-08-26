<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameOption extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'option_text',
        'optionable_id',
        'optionable_type',
        'is_correct',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Get the question that owns the option.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(GameQuestion::class, 'question_id');
    }

    /**
     * Get the parent optionable model (Product, Brand, etc.).
     */
    public function optionable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the display text for the option.
     */
    public function getDisplayTextAttribute(): string
    {
        if ($this->option_text) {
            return $this->option_text;
        }

        if ($this->optionable) {
            return $this->optionable->name ?? $this->optionable->title ?? 'Unknown';
        }

        return 'No text available';
    }
}
