<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --primary: #0d6efd;
            --bg: #f6f8fb;
            --text: #222;
            --muted: #666;
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, 'Helvetica Neue', Arial, sans-serif;
            background: var(--bg);
            color: var(--text)
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0
        }

        .brand {
            font-weight: 700;
            margin-right: 16px
        }

        .nav a {
            color: #333;
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 8px
        }

        .nav a.active {
            background: var(--primary);
            color: #fff
        }

        .spacer {
            flex: 1
        }

        .user {
            color: var(--muted);
            margin-right: 8px
        }

        .container {
            max-width: 1080px;
            margin: 20px auto;
            padding: 0 16px
        }

        .flash {
            background: #e6ffed;
            border: 1px solid #b7f5c8;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 12px
        }

        button,
        .btn {
            padding: 8px 12px;
            border: 0;
            border-radius: 8px;
            background: var(--primary);
            color: #fff;
            cursor: pointer
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #e5e7eb
        }

        h1,
        h2 {
            margin: 6px 0 12px
        }

        .toolbar {
            display: flex;
            gap: 8px;
            align-items: center;
            margin: 10px 0
        }
    </style>
</head>

<body>
    <nav class="nav">
        <div class="brand">deirWaBlast</div>

        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>

        <a href="{{ route('licenses.index') }}"
            class="{{ request()->routeIs('licenses.*') ? 'active' : '' }}">Licenses</a>

        {{-- contoh menu lain (aktifkan kalau ada) --}}
        {{-- <a href="{{ route('packages.index') }}"
       class="{{ request()->routeIs('packages.*') ? 'active' : '' }}">Packages</a> --}}

        <div class="spacer"></div>

        <span class="user">Halo, {{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" style="margin:0">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
</body>

</html>
