<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // ambil keranjang user beserta produk tiap item
        $cart = Auth::user()->cart()->with('items.product')->firstOrCreate([]);
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email',
            'address'        => 'required|string',
            'city'           => 'required|string',
            'zip'            => 'required|string',
            'payment_method' => 'required|in:card,cod',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($user, $data) {
            $cart = $user->cart()->with('items.product')->first();

            if (!$cart || $cart->items->isEmpty()) {
                abort(400, 'Keranjang kosong.');
            }

            // TODO: buat Order & OrderItems di sini. Untuk demo, kosongkan keranjang.
            $cart->items()->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Checkout berhasil.');
    }
}
