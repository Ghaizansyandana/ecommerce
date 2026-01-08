<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Tambahkan semua kolom yang ada di tabel orders kamu ke sini
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_status',
        'name',
        'address',
        'city', // Sesuaikan jika ada
        'zip',  // Sesuaikan jika ada
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke OrderItems (Agar foreach di Controller jalan)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}