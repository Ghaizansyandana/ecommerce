<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar SEMUA pesanan (untuk sisi Admin).
     */
    public function index(Request $request)
    {
        // Jangan pakai auth()->user()->orders() karena itu memfilter hanya milik admin.
        // Gunakan Order::query() untuk mengambil data dari semua user.
        $query = Order::with(['user', 'items']);

        // Fitur Filter Berdasarkan Status (Opsional, agar tombol filter Anda berfungsi)
        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        // Hapus pengecekan 'if ($order->user_id !== auth()->id())' 
        // Agar Admin bisa membuka invoice/detail pesanan milik siapa pun.
        
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }
}