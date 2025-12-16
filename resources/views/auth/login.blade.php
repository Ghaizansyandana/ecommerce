<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="/resources/css/app.css">
</head>
<body style="font-family: system-ui, sans-serif; padding:2rem;">
    <h1>Login</h1>

    @if($errors->any())
        <div style="color: #b91c1c; margin-bottom:1rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom:0.5rem;">
            <label for="email">Email</label><br>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus style="width:300px;padding:.5rem;">
        </div>

        <div style="margin-bottom:0.5rem;">
            <label for="password">Password</label><br>
            <input id="password" name="password" type="password" required style="width:300px;padding:.5rem;">
        </div>

        <div style="margin-bottom:1rem;">
            <label><input type="checkbox" name="remember"> Remember me</label>
        </div>

        <div>
            <button type="submit" style="padding:.5rem 1rem;">Log in</button>
        </div>
    </form>

    <p style="margin-top:1rem;"><a href="/">Back</a></p>
</body>
</html>
