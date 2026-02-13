@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Übersicht</p>
            <h2 class="text-2xl font-semibold text-slate-800">Prüfgeräte</h2>
        </div>

        <a href="{{ route('test-devices.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-green-700">
            + Neues Prüfgerät
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">

        @if($devices->isEmpty())
            <div class="p-10 text-center text-slate-500">
                <p class="text-lg font-medium mb-2">Noch keine Prüfgeräte vorhanden</p>
                <p class="text-sm">Lege dein erstes Messgerät an (z. B. Benning ST725).</p>
            </div>
        @else

        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-6 py-4 font-semibold">Name</th>
                    <th class="text-left px-6 py-4 font-semibold">Icon</th>
                    <th class="text-left px-6 py-4 font-semibold">Seriennummer</th>
                    <th class="text-left px-6 py-4 font-semibold">Kalibriert bis</th>
                    <th class="text-right px-6 py-4 font-semibold">Aktion</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @foreach($devices as $d)
                    @php
                    $expired = $d->calibrated_until && $d->calibrated_until->isPast();

                    $soon = $d->calibrated_until
                        && !$expired
                        && now()->diffInDays($d->calibrated_until, false) <= 60;
                    @endphp

                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-medium text-slate-800">
                            <a href="{{ route('test-devices.show', $d) }}" class="font-medium text-slate-800 hover:text-blue-700">{{ $d->name }}</a>
                        </td>

                        <td class="px-6 py-4">
                            @if($d->primaryMedia)
                                <img src="{{ $d->primaryMedia->thumbnail_url ?? $d->primaryMedia->file_url }}" alt="Icon {{ $d->name }}" class="w-8 h-8 rounded object-cover border border-slate-200">
                            @else
                                <span class="text-slate-400">–</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $d->serial_number }}
                        </td>

                        <td class="px-6 py-4">
                            @if(!$d->calibrated_until)
                                <span class="text-slate-400">–</span>
                            @else
                                <div class="flex items-center gap-3">
                                    <span class="text-slate-700">
                                        {{ $d->calibrated_until->format('d.m.Y') }}
                                    </span>

                                    @if($expired)
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                            abgelaufen
                                        </span>
                                    @elseif($soon)
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                            bald fällig
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">
                                            gültig
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('test-devices.show', $d) }}"
                               class="text-slate-700 hover:text-slate-900 font-medium mr-3">
                                Details
                            </a>
                            <a href="{{ route('test-devices.edit', $d) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                Bearbeiten
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection