@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

        <h2 class="text-xl font-semibold mb-6 text-center">
            Registrierung
        </h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1" for="name">
                    Name
                </label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('name')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1" for="email">
                    E-Mail
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('email')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1" for="password">
                    Passwort
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('password')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1" for="password_confirmation">
                    Passwort bestätigen
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="flex items-center justify-between pt-2">
                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 text-white px-5 py-2 text-sm font-medium hover:bg-blue-700 transition"
                >
                    Registrieren
                </button>

                <a
                    href="{{ route('login') }}"
                    class="text-sm text-slate-600 hover:text-slate-900"
                >
                    Zum Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection