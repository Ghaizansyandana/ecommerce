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


    public function cart()
    {
        return $this->hasOne(\App\Models\Cart::class);
    }


    protected function wishlists()
    {
        return $this->belongsToMany(Product::class, 'wishlists')
                    ->withTimestamps();
    }


    protected function orders()
    {
        return $this->hasOne(Orders::class);
    }


    protected function wishlistProducts()
    {
        return $this->wishlists()->where('product_id', $product->id)->exists();
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


    /**
     * Fungsi yang dicari oleh view product-card
     */
    public function hasInWishlist($productId)
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }
    
    public function getAvatarUrlAttribute(): string
    {
        // Prioritas 1: Avatar yang di-upload (file fisik ada di server)
        // Kita harus cek Storage::exists() agar tidak broken image jika file-nya terhapus manual.
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        // Prioritas 2: Avatar dari Google (URL eksternal dimulai dengan http)
        // Biasanya ini terjadi saat user login via Socialite (Google Sign-In).
        if (str_starts_with($this->avatar ?? '', 'http')) {
            return $this->avatar;
        }

        // Prioritas 3: Gravatar (Layanan sedunia untuk avatar berdasarkan email)
        // Gravatar menggunakan MD5 hash dari email lowercase.
        // Jika user belum punya gravatar, tampilkan 'mp' (Mystery Person).
        // &s=200 artinya size gambar 200x200px.
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }
}
