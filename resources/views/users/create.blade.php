@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-2xl border">
    <h2 class="text-lg font-semibold mb-4">Neuen User anlegen</h2>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <input name="name" value="{{ old('name') }}" class="w-full mb-3 border p-2" placeholder="Name" required>
        <input name="email" type="email" value="{{ old('email') }}" class="w-full mb-3 border p-2" placeholder="E-Mail" required>
        <input name="title" value="{{ old('title') }}" class="w-full mb-3 border p-2" placeholder="Titel (optional)">
        <input name="password" type="password" class="w-full mb-3 border p-2" placeholder="Passwort" required>

        <button class="bg-slate-900 text-white px-4 py-2 rounded-xl">
            Speichern
        </button>
    </form>
</div>
@endsection
