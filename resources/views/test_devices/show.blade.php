@extends('layouts.app')

@section('content')
<div class="space-y-6" id="test-device-media-root" data-csrf="{{ csrf_token() }}">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h2 class="text-xl font-semibold">{{ $testDevice->name }}</h2>
                <p class="text-sm text-slate-600 mt-1">Seriennummer: {{ $testDevice->serial_number }}</p>
                <p class="text-sm text-slate-600 mt-1">
                    Kalibriert bis: {{ optional($testDevice->calibrated_until)->format('d.m.Y') ?? '–' }}
                </p>
            </div>

            <div class="flex gap-2 flex-wrap justify-end">
                <button type="button" id="open-upload-modal" class="px-4 py-2 text-sm rounded-xl border border-slate-300 hover:bg-slate-50">
                    Bilder/Videos
                </button>
                <a href="{{ route('test-devices.edit', $testDevice) }}" class="px-4 py-2 text-sm rounded-xl border border-slate-300 hover:bg-slate-50">
                    Bearbeiten
                </a>
                <form method="POST" action="{{ route('test-devices.destroy', $testDevice) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-sm rounded-xl bg-red-600 text-white hover:bg-red-700">Löschen</button>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold mb-4">Bisherige Prüfungen</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Datum</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Kunde</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Gerät</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($testDevice->inspections as $inspection)
                        <tr>
                            <td class="px-4 py-3">{{ optional($inspection->inspection_date)->format('d.m.Y') }}</td>
                            <td class="px-4 py-3">{{ $inspection->device?->customer?->company ?? '–' }}</td>
                            <td class="px-4 py-3">{{ $inspection->device?->name ?? '–' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-lg {{ $inspection->passed ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $inspection->passed ? 'Bestanden' : 'Nicht bestanden' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-6 text-center text-slate-500">Noch keine Prüfungen vorhanden.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('media.manager', [
        'mediaRootId' => 'test-device-media-root',
        'uploadButtonId' => 'open-upload-modal',
        'mediaItems' => $testDevice->media->values(),
        'mediaBasePath' => '/test-devices/' . $testDevice->id . '/media',
    ])
</div>
@endsection
