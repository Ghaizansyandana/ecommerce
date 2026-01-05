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

        try {
            DB::transaction(function () use ($user, $data) {
                $cart = $user->cart()->with('items.product')->first();

                if (!$cart || $cart->items->isEmpty()) {
                    throw new \Exception('Keranjang kosong');
                }

                // TODO: Buat order & order_items di sini

                // Kosongkan cart
                $cart->items()->delete();
            });
        } catch (\Exception $e) {
            return redirect()
                ->route('cart.index')
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Checkout berhasil.');
    }

   }
