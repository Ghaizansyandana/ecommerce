<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
use App\Models\Order;       
use App\Models\OrderItem;   

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman formulir checkout.
     * Method ini WAJIB ada agar rute GET /checkout tidak error.
     */
    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();

        // Jika keranjang kosong, balikkan ke halaman cart
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda masih kosong.');
        }

        return view('checkout.index', compact('cart'));
    }

    /**
     * Memproses data checkout ke database.
     */
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

        // 1. Buat Order (Hanya gunakan kolom yang pasti ada di database kamu)
        $order = Order::create([
            'user_id'        => $user->id,
            'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount'   => $totalAmount,
            'status'         => 'pending',
            'payment_status' => ($data['payment_method'] == 'card') ? 'paid' : 'unpaid',
            // Hapus baris 'name' dan 'address' jika memang tidak ada di migrasi database kamu
        ]);

        $user = Auth::user();

        try {
            $order = DB::transaction(function () use ($user, $data) {
                $cart = $user->cart()->with('items.product')->first();

                if (!$cart || $cart->items->isEmpty()) {
                    throw new \Exception('Keranjang kosong');
                }

                // Hitung Total
                $totalAmount = $cart->items->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                });

                // 1. Buat Order
                $order = Order::create([
                    'user_id'        => $user->id,
                    'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
                    'total_amount'   => $totalAmount,
                    'status'         => 'pending',
                    // Jika demo kartu, set langsung Paid agar masuk grafik
                    'payment_status' => ($data['payment_method'] == 'card') ? 'paid' : 'unpaid',
                    'name'           => $data['name'],
                    'address'        => $data['address'] . ', ' . $data['city'] . ' ' . $data['zip'],
                ]);

                // 2. Simpan Items ke OrderItem
                foreach ($cart->items as $item) {
                    $order->items()->create([
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity,
                        'price'      => $item->product->price,
                    ]);
                }

                // 3. Kosongkan Cart
                $cart->items()->delete();

                return $order;
            });

            // Redirect ke halaman sukses (Biasanya ke daftar pesanan user)
            return redirect()->route('admin.orders.index')->with('success', 'Checkout berhasil!');

        } catch (\Exception $e) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Gagal Checkout: ' . $e->getMessage());
        }
    }
}