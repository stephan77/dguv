@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content: space-between; align-items:center;">
            <div>
                <h2>{{ $customer->company }}</h2>
                <p>{{ $customer->street }}, {{ $customer->zip }} {{ $customer->city }}</p>
                <p>{{ $customer->email }} · {{ $customer->phone }}</p>
            </div>
            <div>
                <a class="btn btn-secondary" href="{{ route('customers.edit', $customer) }}">Bearbeiten</a>
                <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Löschen</button>
                </form>
                <a class="btn" href="{{ route('customers.report', $customer) }}">PDF Bericht</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="display:flex; justify-content: space-between; align-items:center;">
            <h3>Geräte</h3>
            <a class="btn" href="{{ route('customers.devices.create', $customer) }}">Neues Gerät</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Inventar</th>
                    <th>Gerät</th>
                    <th>Nächste Prüfung</th>
                    <th>Prüfungen</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customer->devices as $device)
                    <tr>
                        <td>{{ $device->inventory_number }}</td>
                        <td>{{ $device->name }}</td>
                        <td>{{ optional($device->next_inspection)->format('d.m.Y') }}</td>
                        <td>{{ $device->inspections->count() }}</td>
                        <td><a class="btn btn-secondary" href="{{ route('devices.show', $device) }}">Details</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5">Noch keine Geräte.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
