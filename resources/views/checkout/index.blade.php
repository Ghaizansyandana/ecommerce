<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Detail Pengiriman</h4>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('checkout.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota</label>
                                <input type="text" name="city" value="{{ old('city') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" name="zip" value="{{ old('zip') }}" class="form-control" required>
                            </div>
                        </div>

                        <h5 class="mt-4">Metode Pembayaran</h5>
                        <div class="mb-3">
                            <select name="payment_method" class="form-select" required>
                                <option value="card" {{ old('payment_method')=='card' ? 'selected' : '' }}>Kartu (demo)</option>
                                <option value="cod" {{ old('payment_method')=='cod' ? 'selected' : '' }}>Bayar di Tempat</option>
                            </select>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">Checkout Sekarang</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Ringkasan Pesanan</h5>

                    @php
                        $items = $cart->items ?? collect();
                        $total = 0;
                    @endphp

                    @if($items->isEmpty())
                        <p class="text-muted">Keranjang kosong.</p>
                    @else
                        <ul class="list-group mb-3">
                            @foreach($items as $it)
                                @php
                                    $price = $it->product->price ?? 0;
                                    $line = $price * $it->quantity;
                                    $total += $line;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $it->product->name ?? 'Produk tidak ditemukan' }}</div>
                                        <small class="text-muted">Qty: {{ $it->quantity }} &middot; Rp{{ number_format($price,0,',','.') }}</small>
                                    </div>
                                    <div class="fw-semibold">Rp{{ number_format($line,0,',','.') }}</div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between pb-2">
                            <div class="text-muted">Subtotal</div>
                            <div class="fw-semibold">Rp{{ number_format($total,0,',','.') }}</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="text-muted">Ongkir</div>
                            <div class="fw-semibold">Rp0</div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fs-5">
                            <div>Total</div>
                            <div class="fw-bold">Rp{{ number_format($total,0,',','.') }}</div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>