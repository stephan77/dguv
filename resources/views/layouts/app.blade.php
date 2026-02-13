<body class="bg-slate-100 text-slate-900 antialiased">
<div
    x-data="{
        isDesktop: window.matchMedia('(min-width: 1024px)').matches,
        sidebarOpen: window.matchMedia('(min-width: 1024px)').matches,
        init() {
            const mq = window.matchMedia('(min-width: 1024px)');
            const apply = () => {
                this.isDesktop = mq.matches;
                this.sidebarOpen = mq.matches; // Desktop immer offen, Mobile immer zu
            };
            apply();
            mq.addEventListener ? mq.addEventListener('change', apply) : mq.addListener(apply);
        }
    }"
    x-cloak
    class="min-h-screen flex"
>
    @auth
        <!-- Overlay (nur Mobile/Tablet, nur wenn offen) -->
        <div
            class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"
            x-show="sidebarOpen && !isDesktop"
            x-transition.opacity
            @click="sidebarOpen = false"
        ></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 bg-slate-900 text-white transition-transform duration-300
                   w-64 lg:static lg:translate-x-0 lg:w-64"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <!-- HEADER -->
            <div class="flex items-center justify-between px-6 py-6">
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Dashboard</p>
                    <h1 class="text-lg font-semibold truncate">DGUV Prüfmanagement</h1>
                </div>

                <!-- Mobile Close -->
                <button class="lg:hidden" type="button" @click="sidebarOpen = false" aria-label="Menü schließen">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- NAV (dein bestehender Nav bleibt unverändert) -->
            <nav class="px-3 pb-6">
                {{-- ... bestehende Links ... --}}
            </nav>
        </aside>
    @endauth

    <!-- Content -->
    <div class="flex-1">
        <header class="sticky top-0 z-30 flex items-center justify-between border-b border-slate-200 bg-white/80 px-6 py-4 backdrop-blur">
            <div class="flex items-center gap-3">
                @auth
                    <!-- Hamburger nur Mobile -->
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

        <main class="p-4 sm:p-6 lg:p-8">
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
