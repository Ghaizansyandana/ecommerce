<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard - {{ config('app.name') }}</title>
</head>
<body style="font-family: system-ui, sans-serif; padding:2rem;">
    <h1>Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name ?? 'User' }}.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <p><a href="/">Home</a></p>
</body>
</html>
