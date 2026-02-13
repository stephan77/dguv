@extends('layouts.app')

@section('content')
<div class="space-y-6" id="device-media-root" data-device-id="{{ $device->id }}" data-csrf="{{ csrf_token() }}">

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h2 class="text-xl font-semibold flex items-center gap-3">
                    {{ $device->name }}
                    <span class="px-3 py-1 text-xs font-medium bg-slate-100 text-slate-700 rounded-lg">
                        {{ $device->inventory_number }}
                    </span>
                </h2>

                <p class="text-sm text-slate-600 mt-1">
                    {{ $device->manufacturer }} {{ $device->model }} · Seriennr. {{ $device->serial }}
                </p>

                <p class="text-sm text-slate-600 mt-1">
                    Kunde:
                    <span class="font-semibold text-slate-900">
                        {{ $device->customer->company }}
                    </span>
                </p>
            </div>

            <div class="flex gap-2 flex-wrap justify-end mobile-stack-actions">
                <button type="button"
                        id="open-upload-modal"
                        class="px-4 py-2.5 text-sm rounded-xl border border-slate-300 hover:bg-slate-50 inline-flex items-center justify-center touch-target">
                    Bilder/Videos hochladen
                </button>

                <a href="{{ route('devices.edit', $device) }}"
                   class="px-4 py-2.5 text-sm rounded-xl border border-slate-300 hover:bg-slate-50 inline-flex items-center justify-center touch-target">
                    Bearbeiten
                </a>

                <a href="{{ route('devices.label', $device) }}"
                   class="px-4 py-2.5 text-sm rounded-xl bg-slate-900 text-white hover:bg-slate-800 inline-flex items-center justify-center touch-target">
                    Etikett drucken
                </a>

                <form method="POST" action="{{ route('devices.destroy', $device) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2.5 text-sm rounded-xl bg-red-600 text-white hover:bg-red-700 w-full touch-target">
                        Löschen
                    </button>
                </form>
            </div>
        </div>
    </div>


    {{-- INFO GRID --}}
    <div class="grid lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold mb-4">Gerätedaten</h3>

            <div class="space-y-2 text-sm">
                <p><span class="font-medium">Typ:</span> {{ $device->type }}</p>
                <p><span class="font-medium">Standort:</span> {{ $device->location }}</p>
                <p>
                    <span class="font-medium">Nächste Prüfung:</span>
                    {{ optional($device->next_inspection)->format('d.m.Y') }}
                </p>
                <p><span class="font-medium">Notizen:</span> {{ $device->notes }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-2">Neue Prüfung</h3>
                <p class="text-sm text-slate-600">
                    Neue DGUV-Prüfung für dieses Gerät anlegen.
                </p>
            </div>

            <a href="{{ route('devices.inspections.create', $device) }}"
               class="mt-4 inline-flex justify-center px-4 py-2.5 text-sm rounded-xl bg-slate-900 text-white hover:bg-slate-800 touch-target">
                Prüfung anlegen
            </a>
        </div>
    </div>


    {{-- INSPECTIONS --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold mb-4">Bisherige Prüfungen</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm responsive-table-card tablet-compact">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Datum</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Prüfer</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Norm</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Status</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Messwerte</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($device->inspections as $inspection)
                        <tr>
                            <td class="px-4 py-3" data-label="Datum">
                                {{ $inspection->inspection_date->format('d.m.Y') }}
                            </td>

                            <td class="px-4 py-3" data-label="Prüfer">{{ $inspection->inspector }}</td>
                            <td class="px-4 py-3" data-label="Norm">{{ $inspection->standard }}</td>

                            <td class="px-4 py-3" data-label="Status">
                                <span class="px-2 py-1 text-xs rounded-lg
                                    {{ $inspection->passed ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $inspection->passed ? 'Bestanden' : 'Nicht bestanden' }}
                                </span>
                            </td>

                            <td class="px-4 py-3" data-label="Messwerte">
                                @foreach ($inspection->measurements as $measurement)
                                    <div class="mb-3">
                                        <div class="font-semibold">
                                            {{ $measurement->test_type }}
                                        </div>

                                        <div class="{{ $measurement->rpe_result === 'nicht bestanden' ? 'text-red-600 font-medium' : 'text-slate-700' }}">
                                            RPE: {{ $measurement->rpe }} ({{ $measurement->rpe_result }})
                                        </div>

                                        <div class="{{ $measurement->riso_result === 'nicht bestanden' ? 'text-red-600 font-medium' : 'text-slate-700' }}">
                                            RISO: {{ $measurement->riso }} ({{ $measurement->riso_result }})
                                        </div>

                                        <div class="{{ $measurement->leakage_result === 'nicht bestanden' ? 'text-red-600 font-medium' : 'text-slate-700' }}">
                                            Leakage: {{ $measurement->leakage }} ({{ $measurement->leakage_result }})
                                        </div>
                                    </div>
                                @endforeach
                            </td>

                            <td class="px-4 py-3 flex gap-2 mobile-stack-actions" data-label="Aktionen">
                                <a href="{{ route('inspections.edit', $inspection) }}"
                                   class="px-3 py-2 text-xs rounded-lg bg-blue-600 text-white hover:bg-blue-700 inline-flex items-center justify-center touch-target">
                                    Bearbeiten
                                </a>

                                <form method="POST" action="{{ route('inspections.destroy', $inspection) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-2 text-xs rounded-lg bg-red-600 text-white hover:bg-red-700 w-full touch-target">
                                        Löschen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                                Noch keine Prüfungen vorhanden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('media.manager', [
        'mediaRootId' => 'device-media-root',
        'uploadButtonId' => 'open-upload-modal',
        'mediaItems' => $device->media->values(),
        'mediaBasePath' => '/devices/' . $device->id . '/media',
    ])
</div>
@endsection
