<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'avatar',
        'is_active',
    ];

    protected $casts = [
        'password' => 'boolean',
    ];

    

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category-name);
            }
        });
        

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category-name);
            }
        });
    }


    protected function products()
    {
        return $this->hasOne(Product::class);
    }


    protected function activeProducts()
    {
        return $this->hasOne(product::class)->where('is_active', true)->where('stock', '>', 0);
    }


    protected function scopeActive($query)
    {
        return $this->where('is_active', true);
    }


    protected function getProductCountAttribute(): int
    {
        return $this->activeProducts()->count();
    }


    protected function getImageAttribute(): string
    {
        if ($this->image) {
            return assets('storage/' . $this->image);
        }
        return asset('image/category-placeholder.png');
    }
}
