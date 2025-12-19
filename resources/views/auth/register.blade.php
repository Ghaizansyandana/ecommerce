<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register - {{ config('app.name') }}</title>
</head>
<body style="font-family: system-ui, sans-serif; padding:2rem;">
    <h1>Register</h1>

    @if($errors->any())
        <div style="color: #b91c1c; margin-bottom:1rem;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom:0.5rem;">
            <label for="name">Name</label><br>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus style="width:300px;padding:.5rem;">
        </div>

        <div style="margin-bottom:0.5rem;">
            <label for="email">Email</label><br>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required style="width:300px;padding:.5rem;">
        </div>

        <div style="margin-bottom:0.5rem;">
            <label for="password">Password</label><br>
            <input id="password" name="password" type="password" required style="width:300px;padding:.5rem;">
        </div>

        <div style="margin-bottom:1rem;">
            <label for="password_confirmation">Confirm Password</label><br>
            <input id="password_confirmation" name="password_confirmation" type="password" required style="width:300px;padding:.5rem;">
        </div>

        <div>
            <button type="submit" style="padding:.5rem 1rem;">Register</button>
        </div>
    </form>

    {{-- ======================================== Tambahkan setelah form register
    ======================================== --}} {{-- Divider --}}
    <div class="position-relative my-4">
    <hr />
    <span
        class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted"
    >
        atau daftar dengan
    </span>
    </div>

    {{-- Google Sign-up Button --}}
    <div class="d-grid gap-2">
    <a href="{{ route('auth.google') }}" class="btn btn-outline-danger btn-lg">
        {{-- Google SVG Icon --}}
        <svg class="me-2" width="20" height="20" viewBox="0 0 24 24">
        {{-- ... SVG paths sama seperti di login ... --}}
        </svg>
        Daftar dengan Google
    </a>
    </div>

    {{-- Teks login --}}
    <p class="mt-4 text-center mb-0">
    Sudah punya akun?
    <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
        Login
    </a>
    </p>

    <p style="margin-top:1rem;"><a href="/">Back</a></p>
</body>
</html>
