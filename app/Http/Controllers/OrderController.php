<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik user yang sedang login.
     */
    public function index(Request $request)
    {
        $orders = auth()->user()
            ->orders()
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        // 1. Authorize (Security Check)
        // User A TIDAK BOLEH melihat pesanan User B.
        // Kita cek apakah ID pemilik order sama dengan ID user yang login.
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // 2. Load relasi detail
        // Kita butuh data items dan gambar produknya untuk ditampilkan di invoice view.
        $order->load(['items.product', 'items.product.primaryImage']);

        return view('orders.show', compact('order'));
    }
}