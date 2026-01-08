<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama
        $stats = [
            'total_revenue' => Order::whereIn('status', ['processing', 'completed'])->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->where('payment_status', 'paid')->count(),
            'total_products' => Product::count(),
            'low_stock'      => Product::where('stock', '<=', 5)->count(),
        ];

        // 2. Pesanan Terbaru
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // 3. Produk Terlaris
        $topProducts = Product::withCount(['orderItems as sold' => function ($q) {
                $q->select(DB::raw('SUM(quantity)'))
                  ->whereHas('order', function($query) {
                      $query->where('payment_status', 'paid');
                  });
            }])
            ->having('sold', '>', 0)
            ->orderByDesc('sold')
            ->take(6)
            ->get();

        // 4. Data Grafik (Logika Perbaikan)
        // Kita ambil data 7 hari terakhir
        $revenueChartData = Order::select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            ])
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(6)) 
            ->groupByRaw('DATE(created_at)') // Perbaikan: Gunakan groupByRaw
            ->orderBy('date', 'asc')
            ->get();

        // Mapping agar tanggal yang kosong tetap muncul dengan nilai 0 (Opsional tapi bagus)
        $revenueChart = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $found = $revenueChartData->where('date', $date)->first();
            
            $revenueChart->push([
                'date'  => now()->subDays($i)->format('d M'), // Format lebih cantik: 08 Jan
                'total' => $found ? $found->total : 0
            ]);
        }

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'revenueChart'));
    }
}