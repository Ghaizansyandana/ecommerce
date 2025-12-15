<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: system-ui, ;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        h1 {
            color: #4f46e5;
        }
    </style>
</head>
<body>
    <h1>Tentang Toko Gojin</h1>
    <p>Selamat datang di toko gojin kami.</p>
    <p>Dibuat dengan mengunakan cinta.</p>
    

    <p>Waktu saat ini: {{ now()->format('d M Y, H:i:s') }}</p>

    <a href="/">Kembali ke Home</a>
    <a href="{{ route('produk.detail', ['id' => 1]) }}">Lihat Produk 1</a>
    <a href="{{ route('produk.detail', ['id' => 2]) }}">Lihat Produk 2</a>
</body>
</html>