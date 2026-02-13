<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f172a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="DGUV Prüfmanagement">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
    <title>{{ config('app.name', 'DGUV Prüfmanagement') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900 antialiased">

<div
    x-data="{
        isDesktop: window.matchMedia('(min-width: 1024px)').matches,
        sidebarOpen: window.matchMedia('(min-width: 1024px)').matches,
        init() {
            window.addEventListener('resize', () => {
                this.isDesktop = window.matchMedia('(min-width: 1024px)').matches;

                if (! this.isDesktop) {
                    this.sidebarOpen = false;
                }
            });
        }
    }"
    class="min-h-screen flex"
>

    @auth
        <!-- MOBILE OVERLAY -->
        <div class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"
             x-show="sidebarOpen && !isDesktop"
             x-cloak
             x-transition.opacity
             @click="sidebarOpen = false"></div>

        <!-- SIDEBAR -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-all duration-300 lg:static lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0 lg:w-64' : '-translate-x-full lg:translate-x-0 lg:w-20'"
        >
            <!-- HEADER -->
            <div class="flex items-center justify-between px-6 py-6">
                <div x-show="sidebarOpen">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Dashboard</p>
                    <h1 class="text-lg font-semibold">DGUV Prüfmanagement</h1>
                </div>

                <!-- DESKTOP TOGGLE -->
                <button @click="sidebarOpen = !sidebarOpen"
                        class="hidden lg:block text-slate-300 hover:text-white text-xl">
                    ☰
                </button>

                <!-- MOBILE CLOSE -->
                <button class="lg:hidden" type="button" @click="sidebarOpen = false">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- NAV -->
            <nav class="px-3 pb-6">
                <div class="space-y-2">

                    <a class="flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 hover:bg-slate-800"
                       href="{{ route('dashboard') }}">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">
                            🏠
                        </span>
                        <span x-show="sidebarOpen">Dashboard</span>
                    </a>

                    <a class="flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 hover:bg-slate-800"
                       href="{{ route('customers.index') }}">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">👥</span>
                        <span x-show="sidebarOpen">Kunden</span>
                    </a>

                    <a class="flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 hover:bg-slate-800"
                       href="{{ route('devices.index') }}">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">🧰</span>
                        <span x-show="sidebarOpen">Geräte</span>
                    </a>

                    <a class="flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 hover:bg-slate-800"
                       href="{{ route('imports.index') }}">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">📥</span>
                        <span x-show="sidebarOpen">Import</span>
                    </a>

                    <a class="flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 hover:bg-slate-800"
                       href="{{ route('reports.index') }}">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">📊</span>
                        <span x-show="sidebarOpen">Berichte</span>
                    </a>

                    <a class="flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 hover:bg-slate-800"
                       href="{{ route('users.index') }}">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">👤</span>
                        <span x-show="sidebarOpen">Benutzer</span>
                    </a>
                    <a class="flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-200 hover:bg-slate-800"
                        href="{{ route('test-devices.index') }}">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800">🧪</span>
                        <span x-show="sidebarOpen">Prüfgeräte</span>
                    </a>
                </div>
            </nav>

            <!-- USER -->
            <div class="mt-auto border-t border-slate-800 px-6 py-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-sm font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="flex-1 text-sm" x-show="sidebarOpen">
                        <p class="font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400">Angemeldet</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-4" x-show="sidebarOpen">
                    @csrf
                <button class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm font-medium text-slate-100 hover:border-slate-500 min-h-11">
                        Logout
                    </button>
                </form>
            </div>
        </aside>
    @endauth

    <!-- CONTENT -->
    <div class="flex-1 transition-all duration-300"
         :class="sidebarOpen ? 'lg:pl-64' : 'lg:pl-20'">

        <header class="sticky top-0 z-30 flex items-center justify-between border-b border-slate-200 bg-white/80 px-6 py-4 backdrop-blur">
            <div class="flex items-center gap-3">
                @auth
                    <button
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-xl font-semibold text-slate-700 lg:hidden"
                        type="button"
                        @click="sidebarOpen = true"
                        aria-label="Menü öffnen"
                    >
                        ☰
                    </button>
                @endauth

                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Übersicht</p>
                    <h2 class="text-xl font-semibold">Inspektionszentrum</h2>
                </div>
            </div>
        </header>

        <main class="p-4 sm:p-6 lg:p-8 ">
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
