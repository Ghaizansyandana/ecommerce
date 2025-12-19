<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pesanan Saya</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h3 class="mb-4">Pesanan Saya</h3>

    @php $orders = $orders ?? collect(); @endphp

    @if($orders->isEmpty())
        <div class="card">
            <div class="card-body text-center text-muted">
                Belum ada pesanan.
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id ?? '-' }}</td>
                                <td>{{ optional($order->created_at)->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ $order->status ?? 'pending' }}</td>
                                <td class="text-end">Rp{{ number_format($order->total ?? 0,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="mt-3">
        @if(\Illuminate\Support\Facades\Route::has('products.index'))
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali Belanja</a>
        @else
            <a href="{{ url('/') }}" class="btn btn-secondary">Kembali Belanja</a>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>