@props(['title' => config('app.name')])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-light">
    <div class="min-vh-100">
        {{-- Header slot --}}
        @if (isset($header))
            <header class="bg-white border-bottom py-3">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- Main content --}}
        <main class="container py-4">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        @include('partials.footer')
    </div>

    @stack('scripts')
</body>
</html>
