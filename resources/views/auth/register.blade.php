<!doctype html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Buat Akun Google Anda - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center p-4">

    <div class="max-w-[450px] w-full bg-white border border-gray-200 rounded-lg p-10 shadow-sm">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 mb-2">Buat Akun</h1>
            <p class="text-gray-600">Gunakan Akun {{ config('app.name') }} Anda</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-700 p-3 rounded-md text-sm mb-6 border border-red-100">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="relative group">
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    class="block w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Nama Lengkap">
            </div>

            <div class="relative group">
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="block w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Alamat Email">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <input type="password" id="password" name="password" required
                    class="block w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Sandi">
                
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="block w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Konfirmasi">
            </div>
            <p class="text-xs text-gray-500 mt-1 px-1">Gunakan minimal 8 karakter dengan campuran huruf, angka & simbol.</p>

            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-700 text-sm">
                    Login saja?
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-700 transition-colors focus:ring-4 focus:ring-blue-200">
                    Berikutnya
                </button>
            </div>
        </form>

        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
            <div class="relative flex justify-center text-sm"><span class="px-2 bg-white text-gray-500">atau daftar dengan</span></div>
        </div>

        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 border border-gray-300 px-4 py-2.5 rounded-md hover:bg-gray-50 transition-colors duration-200">
            <svg width="18" height="18" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 12-4.53z" fill="#EA4335"/>
            </svg>
            <span class="text-gray-700 font-medium text-sm">Daftar dengan Google</span>
        </a>

        <div class="mt-8 text-center">
            <a href="/" class="text-xs text-gray-500 hover:underline">Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>