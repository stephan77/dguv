@extends('layouts.app')

@section('content')
    @php
        $summaryCards = [
            ['title' => 'Gesamtkunden', 'value' => '128', 'trend' => '+12% diesen Monat', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857'],
            ['title' => 'Geräte gesamt', 'value' => '2.418', 'trend' => '+4,6% seit letzter Woche', 'icon' => 'M9.75 17L9 20l6-3'],
            ['title' => 'Fällige Prüfungen', 'value' => '86', 'trend' => '24 innerhalb von 7 Tagen', 'icon' => 'M12 8v4l3 3'],
            ['title' => 'Fehlerhafte Geräte', 'value' => '14', 'trend' => '3 neue Hinweise', 'icon' => 'M12 9v2m0 4h.01'],
        ];

        $customers = [
            ['name' => 'Nordwind Holding', 'location' => 'Hamburg', 'contact' => 'J. Meier', 'status' => 'Aktiv', 'devices' => 324],
            ['name' => 'Stahl & Sohn', 'location' => 'Dortmund', 'contact' => 'K. Loren', 'status' => 'Aktiv', 'devices' => 198],
            ['name' => 'Seaside Logistics', 'location' => 'Kiel', 'contact' => 'M. Novak', 'status' => 'Prüfung fällig', 'devices' => 96],
            ['name' => 'Atlas IT Services', 'location' => 'Berlin', 'contact' => 'R. Schneider', 'status' => 'Aktiv', 'devices' => 412],
        ];

        $devices = [
            ['name' => 'Bohrmaschine X4', 'serial' => 'X4-9234', 'customer' => 'Stahl & Sohn', 'status' => 'Bestanden', 'next' => '12.04.2025'],
            ['name' => 'Server Rack 7', 'serial' => 'SR-3091', 'customer' => 'Atlas IT Services', 'status' => 'Fällig', 'next' => '28.03.2025'],
            ['name' => 'Gabelstapler L2', 'serial' => 'GL-8821', 'customer' => 'Nordwind Holding', 'status' => 'Nicht bestanden', 'next' => 'Sofort'],
            ['name' => 'Schweißgerät Pro', 'serial' => 'SW-5530', 'customer' => 'Seaside Logistics', 'status' => 'Bestanden', 'next' => '19.06.2025'],
        ];

        $inspections = [
            ['device' => 'Server Rack 7', 'inspector' => 'L. Berger', 'result' => 'Bestanden', 'date' => '18.02.2025', 'note' => 'Isolationswerte innerhalb der Norm.'],
            ['device' => 'Gabelstapler L2', 'inspector' => 'S. Neumann', 'result' => 'Nicht bestanden', 'date' => '14.02.2025', 'note' => 'Schutzleiter prüfen, Reparatur nötig.'],
            ['device' => 'Bohrmaschine X4', 'inspector' => 'T. Weiß', 'result' => 'Bestanden', 'date' => '11.02.2025', 'note' => 'Keine Abweichungen festgestellt.'],
            ['device' => 'Ladestation 03', 'inspector' => 'A. Kruse', 'result' => 'Fällig', 'date' => 'In 5 Tagen', 'note' => 'Prüfung für Ende des Monats geplant.'],
        ];
    @endphp

    <section class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-2xl font-semibold">DGUV-Inspektionsdashboard</h3>
                <p class="text-sm text-slate-500">Zentrale Übersicht für Kunden, Geräte und Prüfstatus.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:shadow"
                        type="button">
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
                                <tr class="text-slate-600">
                                    <td class="py-3 font-medium text-slate-900">{{ $customer['name'] }}</td>
                                    <td class="py-3">{{ $customer['location'] }}</td>
                                    <td class="py-3">{{ $customer['contact'] }}</td>
                                    <td class="py-3">{{ $customer['devices'] }}</td>
                                    <td class="py-3">
                                        @if ($customer['status'] === 'Aktiv')
                                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">{{ $customer['status'] }}</span>
                                        @else
                                            <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-600">{{ $customer['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

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
                                    <td class="py-3 font-medium text-slate-900">{{ $device['name'] }}</td>
                                    <td class="py-3">{{ $device['serial'] }}</td>
                                    <td class="py-3">{{ $device['customer'] }}</td>
                                    <td class="py-3">
                                        @if ($device['status'] === 'Bestanden')
                                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">{{ $device['status'] }}</span>
                                        @elseif ($device['status'] === 'Nicht bestanden')
                                            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-600">{{ $device['status'] }}</span>
                                        @else
                                            <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-600">{{ $device['status'] }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3">{{ $device['next'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-semibold">Prüfhistorie</h4>
                        <p class="text-sm text-slate-500">Letzte Ergebnisse & Hinweise.</p>
                    </div>
                    <button class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600">
                        Filter
                    </button>
                </div>
                <div class="mt-6 space-y-4">
                    @foreach ($inspections as $inspection)
                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">{{ $inspection['device'] }}</p>
                                    <p class="text-xs text-slate-500">Prüfer: {{ $inspection['inspector'] }}</p>
                                </div>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold
                                    @if ($inspection['result'] === 'Bestanden')
                                        bg-emerald-50 text-emerald-600
                                    @elseif ($inspection['result'] === 'Nicht bestanden')
                                        bg-rose-50 text-rose-600
                                    @else
                                        bg-amber-50 text-amber-600
                                    @endif
                                ">
                                    {{ $inspection['result'] }}
                                </span>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                                <span>{{ $inspection['date'] }}</span>
                                <span>{{ $inspection['note'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-900 to-slate-800 p-6 text-white shadow-sm">
                <h4 class="text-lg font-semibold">Nächste Schritte</h4>
                <p class="mt-2 text-sm text-slate-200">Planen Sie Inspektionen für Geräte mit anstehenden Terminen und weisen Sie Prüfer zu.</p>
                <div class="mt-6 space-y-3 text-sm">
                    <div class="flex items-center justify-between rounded-xl bg-white/10 px-4 py-3">
                        <span>24 Prüfungen in 7 Tagen</span>
                        <span class="rounded-full bg-amber-400/20 px-2 py-1 text-xs text-amber-200">Priorität</span>
                    </div>
                    <div class="flex items-center justify-between rounded-xl bg-white/10 px-4 py-3">
                        <span>8 Geräte mit Sperrung</span>
                        <span class="rounded-full bg-rose-400/20 px-2 py-1 text-xs text-rose-200">Sofort</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
