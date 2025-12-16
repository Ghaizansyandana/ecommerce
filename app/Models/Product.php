<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;



    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'weight',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);

                $count = static::where('slug', 'like', $product->slug . '%')->count();
                if ($count > 0) {
                    $product->slug .= '-' . ($count + 1);
                }
            }
        });
    }


    protected function category()
    {
        return $this->belongsTo(Category::class);
    }


    protected function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }


    protected function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }


    protected function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    protected function getDisplayPriceAttribute(): float
    {
        return $this->discount_price ?? $this->price;
    }

    protected function getFormattedPriceAttribute(): string
    {
        return 'Rp' . number_format($this->display_price, 0, ",", ".");
    }

    protected function getDiscountPercentageAttribute(): int
    {
        if (!$this->has_discount) {
            return 0;
        }
        return round((($this->price - $this->discount_price) / $this->price ) * 100);
    }

    protected function getHasDiscountAttribute(): bool
    {
        return $this->discount_price !== null && $this->discount_price < $this->price;
    }

    protected function getImageAttribute(): string
    {
        if ($this->primaryImage) {
            return $this->primaryImage->image_url;
        }
        return asset('images/no-image.png');
    }

    protected function getIsAvailableAttribute(): bool
    {
        return $this->is_active && $this->stock > 0;
    }

    protected function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    protected function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }


    protected function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }


    protected function scopeByCategory($query, string $categorySlug)
    {
        return $query->whereHas('category', function($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }


    protected function scopeSearch($query, string $keyboard)
    {
        return $query->where(function ($q) use ($keyboard) {
            $q->where('name', 'like', "%{$keyboard}%")
              ->orWhere('description', 'like', "%{$keyboard}%");
        });
    }


    protected function scopePriceRange($query, float $min, float $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    
}
