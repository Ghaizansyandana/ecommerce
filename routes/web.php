<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Services\MidtransService;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang', function () {
    return view('tentang');
});


Route::get('/sapa/{nama}', function ($nama) {
    return "Halo, $nama! Selamat datang di Toko Gojin.";
});


Route::get('/kategori/{nama?}', function ($nama = 'Semua') {
    return "Menampilkan kategori: $nama";
});


Route::get('/produk/{id}', function ($id) {
    return "Detail produk #$id";
})->name('produk.detail');


// Authentication routes (simple)
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Register
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Lightweight route to satisfy verification.send used in profile forms.
Route::post('email/verification-notify', function () {
    return back()->with('info', 'Fitur verifikasi email belum dikonfigurasi di lingkungan ini.');
})->name('verification.send');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('/profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('/profile.update');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('/profile.update');
}); 

// Admin routes temporarily disabled while admin controllers are missing.
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::resource('/products', AdminProductController::class);
// });

Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google', 'redirect')
    ->name('auth.google');
    Route::get('/auth/google/callback', 'callback')
    ->name('auth.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.destroy');
});

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Katalog Produk
Route::get('/products', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

// ================================================
// HALAMAN YANG BUTUH LOGIN (Customer)
// ================================================

Route::middleware('auth')->group(function () {
    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Pesanan Saya
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ================================================
// HALAMAN ADMIN (Butuh Login + Role Admin)
// ================================================

// Admin routes temporarily disabled while admin controllers are missing.
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Produk CRUD
    Route::resource('products', AdminProductController::class);

    // Kategori CRUD
    Route::resource('categories', AdminCategoryController::class);

    // Manajemen Pesanan
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
// ↑ PENJELASAN LENGKAP:
//
//   Route::get(...) = Ini route untuk HTTP GET request
//   GET adalah method untuk MENAMPILKAN halaman
//   Browser mengirim GET saat user mengetik URL atau klik link
//
//   '/' = URL path, ini adalah homepage
//   http://domain.com/
//
//   [HomeController::class, 'index'] = Handler
//   - HomeController::class = nama class controller (import di atas)
//   - 'index' = nama method yang akan dipanggil
//   Jadi saat user akses /, Laravel memanggil: (new HomeController)->index()
//
//   ->name('home') = Beri nama route
//   Nama ini dipakai di view: route('home') -> "http://domain.com/"
//   Ini SANGAT PENTING! Jangan hardcode URL di view.
//   Jika nanti URL berubah, cukup ubah di sini, semua view otomatis updated.


Route::get('/products', [CatalogController::class, 'index'])->name('catalog.index');
// ↑ Halaman daftar produk / katalog
//   URL: http://domain.com/products
//   URL dengan filter: http://domain.com/products?category=elektronik&sort=price_asc


Route::get('/products/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
// ↑ ROUTE PARAMETER:
//   {slug} adalah PLACEHOLDER (variable di URL)
//
//   Contoh URL:
//   http://domain.com/products/laptop-gaming-asus
//
//   {slug} akan berisi: "laptop-gaming-asus"
//
//   Di controller, parameter ini diterima:
//   public function show(string $slug) { ... }
//
//   KENAPA PAKAI SLUG, BUKAN ID?
//   - SEO friendly: /products/laptop-gaming lebih baik dari /products/123
//   - Lebih deskriptif untuk user
//   - Lebih aman (tidak expose ID internal)

// ================================================================
// HALAMAN YANG BUTUH LOGIN
// ================================================================

Route::middleware('auth')->group(function () {
// ↑ MIDDLEWARE GROUP:
//   middleware('auth') = Filter yang memeriksa apakah user sudah login
//
//   CARA KERJA:
//   1. User request /cart
//   2. Middleware 'auth' cek: Auth::check()
//   3. Jika BELUM LOGIN:
//      - Redirect ke /login
//      - Setelah login, redirect balik ke /cart
//   4. Jika SUDAH LOGIN:
//      - Lanjutkan ke CartController@index
//
//   group(function () { ... }) = semua route di dalam closure
//   akan otomatis punya middleware 'auth'

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    // ↑ Halaman keranjang belanja

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    // ↑ POST route untuk MENAMBAH item ke keranjang
    //   POST dipakai karena ini MENGUBAH data (create new cart item)
    //   Dipanggil dari form: <form method="POST" action="{{ route('cart.add') }}">

    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    // ↑ PATCH route untuk UPDATE quantity
    //   PATCH = update sebagian data (hanya quantity, bukan semua field)
    //   {item} = ID cart item yang diupdate
    //
    //   Di form HTML, kita pakai METHOD SPOOFING:
    //   <form method="POST">
    //       @csrf
    //       @method('PATCH')  <!-- Ini memberitahu Laravel untuk treat sebagai PATCH -->
    //   </form>

    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');
    // ↑ DELETE route untuk HAPUS item dari keranjang
    //   Method DELETE tidak didukung form HTML biasa
    //   Pakai @method('DELETE') seperti PATCH di atas
});

// ================================================================
// HALAMAN ADMIN
// ================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
// ↑ PENJELASAN SETIAP BAGIAN:
//
//   middleware(['auth', 'admin'])
//   - MULTIPLE MIDDLEWARE! Harus:
//     1. Sudah login (auth)
//     2. DAN role-nya admin (admin) - middleware custom
//   - Jika salah satu gagal, akses ditolak
//
//   prefix('admin')
//   - Semua route di dalam group akan punya prefix /admin
//   - Route::get('/products') jadi /admin/products
//   - URL: http://domain.com/admin/products
//
//   name('admin.')
//   - Semua route name akan punya prefix 'admin.'
//   - name('products.index') jadi 'admin.products.index'
//   - Pakai: route('admin.products.index')
//
//   Jadi kombinasinya:
//   Route yang di-define /products dengan name products.index
//   Jadi: URL /admin/products dengan name admin.products.index

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // ↑ Admin dashboard
    //   URL: /admin
    //   Name: admin.dashboard

    Route::resource('products', AdminProductController::class);
    // ↑ RESOURCE ROUTE: Shortcut untuk 7 route CRUD sekaligus!
    //
    //   SAMA DENGAN MENULIS:
    //   Route::get('/products', [Controller::class, 'index'])->name('products.index');
    //   Route::get('/products/create', [Controller::class, 'create'])->name('products.create');
    //   Route::post('/products', [Controller::class, 'store'])->name('products.store');
    //   Route::get('/products/{product}', [Controller::class, 'show'])->name('products.show');
    //   Route::get('/products/{product}/edit', [Controller::class, 'edit'])->name('products.edit');
    //   Route::put('/products/{product}', [Controller::class, 'update'])->name('products.update');
    //   Route::delete('/products/{product}', [Controller::class, 'destroy'])->name('products.destroy');
    //
    //   Dengan prefix dan name prefix, jadi:
    //   URL: /admin/products, /admin/products/create, dll
    //   Name: admin.products.index, admin.products.create, dll
});

// ================================================================
// ROUTE AUTHENTICATION (dari Laravel UI)
// ================================================================

Auth::routes();
// ↑ SHORTCUT untuk route login/register/logout/password reset
//
//   Ini membuat route:
//   - GET /login (halaman form login)
//   - POST /login (proses login)
//   - POST /logout (proses logout)
//   - GET /register (halaman form register)
//   - POST /register (proses register)
//   - GET /password/reset (halaman forgot password)
//   - POST /password/email (kirim email reset)
//   - GET /password/reset/{token} (halaman reset password)
//   - POST /password/reset (proses reset password)
//
//   Lihat detail: php artisan route:list | grep -E 'login|register|password'

// NOTE: Using custom AuthController routes above; removed Auth::routes() to
// avoid duplicate/default Laravel auth route conflicts.

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Kategori
    Route::resource('categories', CategoryController::class)->except(['show']);
    // Produk
    Route::resource('products', ProductController::class);
});

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/product/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

Route::middleware('auth')->group(function() {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::middleware('auth', 'admin')->group(function() {
    Route::get('/wishlist', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::get('/admin/reports/sales', [App\Http\Admin\ReportController::class, 'sales'])->name('admin.reports.sales');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

Route::get('/admin/reports/sales', [ReportController::class, 'sales'])->name('admin.reports.sales');

Route::get('/wishlist', function () {
    return "Halaman Wishlist";
})->name('wishlist.index');

Route::get('/debug-midtrans', function () {
    $config = [
        'merchant_id'   => config('midtrans.merchant_id'),
        'client_key'   => config('midtrans.client_key'),
        'server_key'   => config('midtrans.server_key') ? '***SET***': 'NOT SET',
        'is_production'   => config('midtrans.is_production'),
    ];

    try {
        $service = new MidtransService();

        // Buat dummy order untuk testing
        $dummyOrder = new \App\Models\Order();
        $dummyOrder->order_number = 'TEST-' . time();
        $dummyOrder->total_amount = 10000;
        $dummyOrder->shipping_cost = 0;
        $dummyOrder->shipping_name = 'Test User';
        $dummyOrder->shipping_phone = '08123456789';
        $dummyOrder->shipping_address = 'Jl. Test No. 123';
        $dummyOrder->user = (object) [
            'name'  => 'Tester',
            'email' => 'test@example.com',
            'phone' => '08123456789',
        ];
        // Dummy items
        $dummyOrder->items = collect([
            (object) [
                'product_id'   => 1,
                'product_name' => 'Produk Test',
                'price'        => 10000,
                'quantity'     => 1,
            ],
        ]);

        $token = $service->createSnapToken($dummyOrder);

        return response()->json([
            'status'  => 'SUCCESS',
            'message' => 'Berhasil terhubung ke Midtrans!',
            'config'  => $config,
            'token'   => $token,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'ERROR',
            'message' => $e->getMessage(),
            'config'  => $config,
        ], 500);
    }
});