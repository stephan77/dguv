@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">

    <div class="w-full max-w-md px-6">
        <div class="bg-white/95 backdrop-blur rounded-2xl shadow-2xl p-8">

            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-slate-900">
                    DGUV Prüfmanagement
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Bitte einloggen
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">
                        E-Mail
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800"
                    >
                    @error('email')
                        <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">
                        Passwort
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800"
                    >
                    @error('password')
                        <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-sm text-slate-500">  Eingeloggt bleiben</span>
                </div>

                <button
                    type="submit"
                    class="w-full bg-slate-900 text-white text-sm font-semibold py-2.5 rounded-xl hover:bg-slate-800 transition"
                >
                    Login
                </button>

                <div class="text-center pt-2">
                    @if(setting('registration_enabled', '1') === '1')
                        <a href="{{ route('register') }}" class="text-sm text-slate-300 hover:text-slate-900">
                            Registrieren
                        </a>
                    @endif
                </div>
            </form>

            <div class="text-center text-xs text-slate-300 mt-6">
                © {{ date('Y') }} Stephan Thiel
            </div>
        </div>
    </div>

</div>
@endsection