<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_percent',
        'stock',
        'image',
        'category_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_percent' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /** Harga katalog (sebelum diskon per item). */
    public function listUnitPrice(): float
    {
        return round((float) $this->price, 2);
    }

    /** Harga jual per unit setelah diskon persen per produk. */
    public function sellingUnitPrice(): float
    {
        $list = $this->listUnitPrice();
        $d = $this->discount_percent;
        if ($d === null || (float) $d <= 0) {
            return $list;
        }

        $pct = min(100.0, max(0.0, (float) $d));

        return round($list * (1 - $pct / 100), 2);
    }

    public function hasItemDiscount(): bool
    {
        return $this->discount_percent !== null && (float) $this->discount_percent > 0;
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function productQuestions(): HasMany
    {
        return $this->hasMany(ProductQuestion::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productViews(): HasMany
    {
        return $this->hasMany(ProductView::class);
    }
}
