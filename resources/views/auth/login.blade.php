@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 420px; margin: 0 auto;">
        <h2>Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom: 12px;">
                <label for="email">E-Mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')<div class="status-fail">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label for="password">Passwort</label>
                <input id="password" type="password" name="password" required>
                @error('password')<div class="status-fail">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label><input type="checkbox" name="remember"> Eingeloggt bleiben</label>
            </div>
            <button class="btn" type="submit">Login</button>
            <a class="btn btn-secondary" href="{{ route('register') }}">Registrieren</a>
        </form>
    </div>
@endsection
