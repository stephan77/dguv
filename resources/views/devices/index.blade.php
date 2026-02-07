@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>Geräteübersicht</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Inventar</th>
                    <th>Gerät</th>
                    <th>Kunde</th>
                    <th>Nächste Prüfung</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($devices as $device)
                    <tr>
                        <td>{{ $device->inventory_number }}</td>
                        <td>{{ $device->name }}</td>
                        <td>{{ $device->customer->company }}</td>
                        <td>{{ optional($device->next_inspection)->format('d.m.Y') }}</td>
                        <td><a class="btn btn-secondary" href="{{ route('devices.show', $device) }}">Details</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5">Keine Geräte vorhanden.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 12px;">{{ $devices->links() }}</div>
    </div>
@endsection
