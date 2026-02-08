@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-2xl border">
    <h2 class="text-lg font-semibold mb-4">User bearbeiten</h2>

    <form method="POST" action="{{ route('users.update',$user) }}">
        @csrf
        @method('PUT')

        <input name="name" value="{{ $user->name }}" class="w-full mb-3 border p-2">
        <input name="email" value="{{ $user->email }}" class="w-full mb-3 border p-2">
        <input name="title" value="{{ $user->title }}" class="w-full mb-3 border p-2">

        <input name="password" placeholder="Neues Passwort" class="w-full mb-3 border p-2">

        <button class="bg-slate-900 text-white px-4 py-2 rounded-xl">
            Speichern
        </button>
    </form>
</div>
@endsection