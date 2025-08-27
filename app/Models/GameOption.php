<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function optionableType(): Attribute
    {
        return Attribute::make(
//            get: fn ($value) => match ($value) {
//                \App\Models\Product::class => 'product',
//                \App\Models\Brand::class   => 'brand',
//                default                    => $value,
//            },
            set: fn ($value) => match ($value) {
                'product' => \App\Models\Product::class,
                'brand'   => \App\Models\Brand::class,
                default   => null,
            },
        );
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_correct' => 'boolean',
        'sort_order' => 'integer',
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
        // If option_text is provided, use it
        if (! empty($this->option_text)) {
            return $this->option_text;
        }

        // If optionable relationship exists, get its name
        if ($this->optionable) {
            return $this->optionable->name ?? $this->optionable->title ?? 'Unknown Item';
        }

        return 'No text available';
    }

    /**
     * Get the option type as a string.
     */
    public function getOptionTypeAttribute(): string
    {
        if (! empty($this->option_text)) {
            return 'text';
        }

        if ($this->optionable_type) {
            return strtolower(class_basename($this->optionable_type));
        }

        return 'unknown';
    }

    /**
     * Scope to get only correct options.
     */
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    /**
     * Scope to get only incorrect options.
     */
    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false);
    }

    /**
     * Scope to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
