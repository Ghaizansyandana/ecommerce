<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;

    // Tambahkan baris ini agar data bisa diisi secara massal (mass assignment)
protected $fillable = [
    'order_id',
    'product_id',
    'quantity',
    'price',
];
    /**
     * Relasi ke Model Order (Setiap item pesanan dimiliki oleh satu Order)
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke Model Product (Setiap item pesanan merujuk ke satu Produk)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}