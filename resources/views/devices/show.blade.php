@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content: space-between; align-items:center;">
            <div>
                <h2>{{ $device->name }} <span class="tag">{{ $device->inventory_number }}</span></h2>
                <p>{{ $device->manufacturer }} {{ $device->model }} · Seriennr. {{ $device->serial }}</p>
                <p>Kunde: <strong>{{ $device->customer->company }}</strong></p>
            </div>
            <div>
                <a class="btn btn-secondary" href="{{ route('devices.edit', $device) }}">Bearbeiten</a>
                <a class="btn" href="{{ route('devices.label', $device) }}">Etikett drucken</a>
                <form method="POST" action="{{ route('devices.destroy', $device) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Löschen</button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <h3>Gerätedaten</h3>
            <p><strong>Typ:</strong> {{ $device->type }}</p>
            <p><strong>Standort:</strong> {{ $device->location }}</p>
            <p><strong>Nächste Prüfung:</strong> {{ optional($device->next_inspection)->format('d.m.Y') }}</p>
            <p><strong>Notizen:</strong> {{ $device->notes }}</p>
        </div>
        <div class="card">
            <h3>Neue Prüfung</h3>
            <a class="btn" href="{{ route('devices.inspections.create', $device) }}">Prüfung anlegen</a>
        </div>
    </div>

    <div class="card">
        <h3>Bisherige Prüfungen</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Prüfer</th>
                    <th>Norm</th>
                    <th>Status</th>
                    <th>Messwerte</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($device->inspections as $inspection)
                    <tr>
                        <td>{{ $inspection->inspection_date->format('d.m.Y') }}</td>
                        <td>{{ $inspection->inspector }}</td>
                        <td>{{ $inspection->standard }}</td>
                        <td>
                            <span class="{{ $inspection->passed ? 'status-pass' : 'status-fail' }}">
                                {{ $inspection->passed ? 'Bestanden' : 'Nicht bestanden' }}
                            </span>
                        </td>
                        <td>
                            @foreach ($inspection->measurements as $measurement)
                                <div style="margin-bottom: 8px;">
                                    <div><strong>{{ $measurement->test_type }}</strong></div>
                                    <div class="{{ $measurement->rpe_result === 'nicht bestanden' ? 'status-fail' : '' }}">RPE: {{ $measurement->rpe }} ({{ $measurement->rpe_result }})</div>
                                    <div class="{{ $measurement->riso_result === 'nicht bestanden' ? 'status-fail' : '' }}">RISO: {{ $measurement->riso }} ({{ $measurement->riso_result }})</div>
                                    <div class="{{ $measurement->leakage_result === 'nicht bestanden' ? 'status-fail' : '' }}">Leakage: {{ $measurement->leakage }} ({{ $measurement->leakage_result }})</div>
                                </div>
                            @endforeach
                        </td>
                        <td>
                            <form method="POST" action="{{ route('inspections.destroy', $inspection) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Löschen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">Noch keine Prüfungen vorhanden.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
