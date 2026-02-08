@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('users.toggleRegistration') }}">
    @csrf
    <button class="px-4 py-2 bg-slate-900 text-white rounded-xl">
        Registrierung {{ setting('registration_enabled') === '1' ? 'deaktivieren' : 'aktivieren' }}
    </button>
</form>
<div class="bg-white rounded-2xl shadow-sm border p-6">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Benutzer</h2>

        <a href="{{ route('users.create') }}"
           class="px-4 py-2 bg-slate-900 text-white rounded-xl">
            Neuer User
        </a>
    </div>

    <table class="w-full text-sm">
        <thead>
        <tr class="bg-slate-50">
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">E-Mail</th>
            <th class="p-3 text-left">Titel</th>
            <th class="p-3"></th>
        </tr>
        </thead>

        <tbody class="divide-y">
        @foreach($users as $user)
            <tr>
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">{{ $user->title }}</td>

                <td class="p-3 text-right">
                    <a href="{{ route('users.edit',$user) }}" class="text-blue-600">Bearbeiten</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection