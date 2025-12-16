<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'google_id',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    protected function cart()
    {
        return $this->hasOne(Cart::class);
    }


    protected function wishlists()
    {
        return $this->hasOne(Wishlists::class);
    }


    protected function orders()
    {
        return $this->hasOne(Orders::class);
    }


    protected function wishlistProducts()
    {
        return $this->hasOne(WishlistProducts::class, 'wishlists')->withTimestamps();
    }


    protected function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    protected function isCustomer(): bool
    {
        return $this->role == 'customer';
    }


    protected function hasWishlist(Product $product): bool
    {
        return $this->wishlists()->where('product_id', $product->$id)->exists();
    }

}
