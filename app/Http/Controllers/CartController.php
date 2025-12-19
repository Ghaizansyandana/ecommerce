<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart()->with('items.product')->firstOrCreate();
        return view('cart.index', compact('cart')); // pastikan view ada
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < 1) {
            return back()->withErrors(['stock' => 'Produk stok habis.']);
        }

        DB::transaction(function () use ($product, $data) {
            $user = Auth::user();

            // dapatkan atau buat cart user
            $cart = $user->cart()->firstOrCreate([]);

            // cari item di keranjang
            $item = $cart->items()->where('product_id', $product->id)->first();

            $addQty = min($data['quantity'], $product->stock);

            if ($item) {
                $newQty = $item->quantity + $addQty;
                // jangan melebihi stok
                $item->update(['quantity' => min($newQty, $product->stock)]);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => $addQty,
                    // tambahkan kolom lain jika model CartItem membutuhkan (harga, dll.)
                ]);
            }
        });

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update($item, Request $request)
    {
        return redirect()->back()->with('success', 'Jumlah keranjang diperbarui (stub).');
    }

    public function remove($item)
    {
        return redirect()->back()->with('success', 'Item keranjang dihapus (stub).');
    }
}
