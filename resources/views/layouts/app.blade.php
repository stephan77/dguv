<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DGUV Prüfmanagement') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
<div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
    <div class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden" x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"></div>

    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 transform bg-slate-900 text-white transition-transform duration-300 lg:static lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="flex items-center justify-between px-6 py-6">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Dashboard</p>
                <h1 class="text-lg font-semibold">DGUV Prüfmanagement</h1>
            </div>
            <button class="lg:hidden" type="button" @click="sidebarOpen = false">
                <span class="sr-only">Sidebar schließen</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="px-4 pb-6">
            <div class="space-y-2">
                <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-slate-800"
                   href="{{ route('dashboard') }}">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v7m4-7v7m5-9l2 2" />
                        </svg>
                    </span>
                    Dashboard
                </a>
                <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-slate-800"
                   href="{{ route('customers.index') }}">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 4a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM7 14a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                    Kunden
                </a>
                <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-slate-800"
                   href="{{ route('devices.index') }}">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l6-3m-6 3v-3m6 3v-3M4 4h16v10H4z" />
                        </svg>
                    </span>
                    Geräte
                </a>
                <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-slate-800"
                   href="{{ route('imports.index') }}">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M4 8V7a3 3 0 013-3h10a3 3 0 013 3v1M12 11v6m0 0l-3-3m3 3l3-3" />
                        </svg>
                    </span>
                    Import
                </a>
                <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-slate-800"
                   href="{{ route('reports.index') }}">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h8M9 7H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4" />
                        </svg>
                    </span>
                    Berichte
                </a>
            </div>
        </nav>
        <div class="mt-auto border-t border-slate-800 px-6 py-6">
            @auth
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-sm font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 text-sm">
                        <p class="font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400">Angemeldet</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-2 text-sm font-medium text-slate-100 transition hover:border-slate-500" type="submit">
                        Logout
                    </button>
                </form>
            @endauth
            @guest
                <a class="inline-flex w-full items-center justify-center rounded-xl bg-slate-800 px-4 py-2 text-sm font-medium text-slate-100 transition hover:bg-slate-700" href="{{ route('login') }}">
                    Login
                </a>
            @endguest
        </div>
    </aside>

    <div class="flex-1 lg:pl-64">
        <header class="sticky top-0 z-30 flex items-center justify-between border-b border-slate-200 bg-white/80 px-6 py-4 backdrop-blur">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Übersicht</p>
                <h2 class="text-xl font-semibold">Inspektionszentrum</h2>
            </div>
            <button class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-slate-300 lg:hidden"
                    type="button" @click="sidebarOpen = true">
                Menü
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </header>

        <main class="px-6 py-8">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
