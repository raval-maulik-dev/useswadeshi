<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAlternative extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'foreign_product_id',
        'local_product_id',
        'note',
    ];

    /**
     * Get the foreign product.
     */
    public function foreignProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'foreign_product_id');
    }

    /**
     * Get the local product.
     */
    public function localProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'local_product_id');
    }
}
