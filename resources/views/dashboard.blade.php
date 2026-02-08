@extends('layouts.app')

@section('content')
@php
$summaryCards = [
    ['title' => 'Gesamtkunden', 'value' => $totalCustomers, 'trend' => 'Im System', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857'],
    ['title' => 'Geräte gesamt', 'value' => $totalDevices, 'trend' => 'Registriert', 'icon' => 'M9.75 17L9 20l6-3'],
    ['title' => 'Fällige Prüfungen', 'value' => $dueInspections, 'trend' => 'Nächste 7 Tage', 'icon' => 'M12 8v4l3 3'],
    ['title' => 'Fehlerhafte Geräte', 'value' => $failedDevices, 'trend' => 'Nicht bestanden', 'icon' => 'M12 9v2m0 4h.01'],
];
@endphp

<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="text-2xl font-semibold">DGUV-Inspektionsdashboard</h3>
            <p class="text-sm text-slate-500">Zentrale Übersicht für Kunden, Geräte und Prüfstatus.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:shadow" type="button">
                <span>Bericht exportieren</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5" />
                </svg>
            </button>
            <a class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-slate-800"
               href="{{ route('customers.create') }}">
                Neuer Kunde
            </a>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($summaryCards as $card)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ $card['title'] }}</p>
                        <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $card['value'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-sm text-slate-500">{{ $card['trend'] }}</p>
            </div>
        @endforeach
    </div>
</section>

<section class="mt-8 grid gap-6 xl:grid-cols-[1.4fr_1fr]">
    <div class="space-y-4">

        {{-- Kunden --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold">Kundenübersicht</h4>
                    <p class="text-sm text-slate-500">Aktive Kunden und deren Prüfvolumen.</p>
                </div>
                <a class="text-sm font-medium text-slate-600 hover:text-slate-900" href="{{ route('customers.index') }}">Alle ansehen</a>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs uppercase tracking-[0.2em] text-slate-400">
                        <tr>
                            <th class="pb-3">Kunde</th>
                            <th class="pb-3">Standort</th>
                            <th class="pb-3">Kontakt</th>
                            <th class="pb-3">Geräte</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->company }}</td>
                                <td>{{ $customer->city }}</td>
                                <td>{{ $customer->contact_person ?? '-' }}</td>
                                <td>{{ $customer->devices_count }}</td>
                                <td>Aktiv</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Geräte --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold">Gerätebestand</h4>
                    <p class="text-sm text-slate-500">Letzte Prüfungen und nächste Termine.</p>
                </div>
                <a class="text-sm font-medium text-slate-600 hover:text-slate-900" href="{{ route('devices.index') }}">Inventar öffnen</a>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs uppercase tracking-[0.2em] text-slate-400">
                        <tr>
                            <th class="pb-3">Gerät</th>
                            <th class="pb-3">Seriennr.</th>
                            <th class="pb-3">Kunde</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Nächste Prüfung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($devices as $device)
                            <tr class="text-slate-600">
                                <td class="py-3 font-medium text-slate-900">{{ $device->name }}</td>
                                <td class="py-3">{{ $device->serial }}</td>
                                <td class="py-3">{{ $device->customer->company ?? '-' }}</td>
                                <td class="py-3">–</td>
                                <td class="py-3">
                                    {{ optional($device->next_inspection)->format('d.m.Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Prüfhistorie --}}
    <div class="space-y-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold">Prüfhistorie</h4>
                    <p class="text-sm text-slate-500">Letzte Ergebnisse & Hinweise.</p>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                @foreach ($inspections as $inspection)
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $inspection->device->name ?? '-' }}
                                </p>
                                <p class="text-xs text-slate-500">
                                    Prüfer: {{ $inspection->inspector }}
                                </p>
                            </div>

                            <span class="rounded-full px-3 py-1 text-xs font-semibold
                                {{ $inspection->passed ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                {{ $inspection->passed ? 'Bestanden' : 'Nicht bestanden' }}
                            </span>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                            <span>{{ $inspection->inspection_date->format('d.m.Y') }}</span>
                            <span>Prüfung durchgeführt</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection