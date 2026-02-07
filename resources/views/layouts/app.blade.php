<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DGUV Prüfmanagement') }}</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f7f7f9; margin: 0; }
        header { background: #0f172a; color: #fff; padding: 16px 24px; }
        nav a { color: #fff; margin-right: 16px; text-decoration: none; }
        main { padding: 24px; }
        .card { background: #fff; border-radius: 8px; padding: 16px; margin-bottom: 16px; box-shadow: 0 2px 4px rgba(15, 23, 42, 0.08); }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 8px 12px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        .btn { display: inline-block; padding: 8px 12px; border-radius: 6px; background: #2563eb; color: #fff; text-decoration: none; }
        .btn-secondary { background: #475569; }
        .btn-danger { background: #dc2626; }
        .status-pass { color: #16a34a; font-weight: 600; }
        .status-fail { color: #dc2626; font-weight: 600; }
        .tag { display: inline-block; padding: 4px 8px; border-radius: 999px; background: #e2e8f0; font-size: 12px; }
        .badge-danger { background: #fee2e2; color: #b91c1c; }
        .badge-ok { background: #dcfce7; color: #15803d; }
        form.inline { display: inline; }
        .grid { display: grid; gap: 16px; }
        .grid-2 { grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
        label { display: block; margin-bottom: 6px; font-weight: 600; }
        input, select, textarea { width: 100%; padding: 8px 10px; border-radius: 6px; border: 1px solid #cbd5f5; }
    </style>
</head>
<body>
<header>
    <div style="display:flex; justify-content: space-between; align-items:center;">
        <div>
            <strong>DGUV V3 Prüfmanagement</strong>
            <nav style="margin-top: 8px;">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('customers.index') }}">Kunden</a>
                <a href="{{ route('devices.index') }}">Geräte</a>
                <a href="{{ route('imports.index') }}">Import</a>
                <a href="{{ route('reports.index') }}">Berichte</a>
            </nav>
        </div>
        <div>
            @auth
                <span style="margin-right: 12px;">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="btn btn-secondary" type="submit">Logout</button>
                </form>
            @endauth
            @guest
                <a class="btn" href="{{ route('login') }}">Login</a>
            @endguest
        </div>
    </div>
</header>
<main>
    @if (session('status'))
        <div class="card">{{ session('status') }}</div>
    @endif

    {{ $slot ?? '' }}
    @yield('content')
</main>
</body>
</html>
