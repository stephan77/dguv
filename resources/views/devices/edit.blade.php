@extends('layouts.app')

@section('content')
<div class="max-w-3xl">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-xl font-semibold mb-6">Gerät bearbeiten</h2>

        <form method="POST" action="{{ route('devices.update', $device) }}" class="space-y-6">
            @csrf
            @method('PUT')

            @include('devices._form', ['device' => $device])

            <div class="flex items-center gap-3 pt-4">
                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-slate-900 text-white text-sm font-medium hover:bg-slate-700 transition">
                    Aktualisieren
                </button>

                <a href="{{ route('devices.show', $device) }}"
                   class="px-5 py-2 rounded-xl border border-slate-300 text-sm hover:bg-slate-50 transition">
                    Abbrechen
                </a>
            </div>
        </form>
    </div>

</div>
@endsection