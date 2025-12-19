<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class CartItem extends Model
{
    protected $fillable = [
        'product_id', // Add this line
        'quantity',
        // ...existing code...
    ];

    /**
     * Product belonging to this cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // ...existing code...
}
