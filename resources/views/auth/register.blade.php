@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 420px; margin: 0 auto;">
        <h2>Registrierung</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div style="margin-bottom: 12px;">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="status-fail">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label for="email">E-Mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="status-fail">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label for="password">Passwort</label>
                <input id="password" type="password" name="password" required>
                @error('password')<div class="status-fail">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label for="password_confirmation">Passwort bestätigen</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <button class="btn" type="submit">Registrieren</button>
            <a class="btn btn-secondary" href="{{ route('login') }}">Zurück zum Login</a>
        </form>
    </div>
@endsection
