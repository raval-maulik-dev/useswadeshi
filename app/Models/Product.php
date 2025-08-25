<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
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
        'product_type',
        'brand_id',
        'category_id',
        'vendor_id',
        'image_url',
    ];

    /**
     * Get the brand that owns the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the vendor that owns the product.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the pledges for the product.
     */
    public function pledges(): HasMany
    {
        return $this->hasMany(Pledge::class);
    }

    /**
     * Get the game questions for the product.
     */
    public function gameQuestions(): HasMany
    {
        return $this->hasMany(GameQuestion::class);
    }

    /**
     * Get the foreign product alternatives.
     */
    public function foreignAlternatives(): HasMany
    {
        return $this->hasMany(ProductAlternative::class, 'foreign_product_id');
    }

    /**
     * Get the local product alternatives.
     */
    public function localAlternatives(): HasMany
    {
        return $this->hasMany(ProductAlternative::class, 'local_product_id');
    }
}
