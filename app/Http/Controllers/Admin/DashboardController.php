<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // <--- TAMBAHKAN BARIS INI
use App\Models\Order; // <--- TAMBAHKAN BARIS INI
use App\Models\Product; // <--- TAMBAHKAN BARIS INI
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ... kode pengambilan data stats ...
        $stats = [
            'total_revenue'  => Order::where('status', 'completed')->sum('total_amount') ?? 0,
            'total_orders'   => Order::count() ?? 0,
            'pending_orders' => Order::where('status', 'pending')->count() ?? 0,
            'low_stock'      => Product::where('stock', '<', 10)->count() ?? 0,
        ];

        // Ambil data recent orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // PERBAIKAN DI SINI: Pastikan recentOrders dimasukkan ke compact
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}