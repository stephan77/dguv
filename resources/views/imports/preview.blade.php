@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>Import Vorschau</h2>
        <form method="POST" action="{{ route('customers.import.store', $customer) }}">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Speicher Nr</th>
                        <th>Bezeichnung</th>
                        <th>Prüfergebnis</th>
                        <th>Prüfdatum</th>
                        <th>Gerät zuordnen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $index => $row)
                        <tr>
                            <td>{{ $row['storage_number'] }}</td>
                            <td>{{ $row['description'] }}</td>
                            <td>{{ $row['result'] }}</td>
                            <td>{{ $row['inspection_date'] }}</td>
                            <td>
                                <select name="device_ids[{{ $index }}]">
                                    <option value="">-- Gerät wählen --</option>
                                    @foreach ($devices as $device)
                                        <option value="{{ $device->id }}">{{ $device->inventory_number }} - {{ $device->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Keine Daten gefunden.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <button class="btn" type="submit">Import bestätigen</button>
            <a class="btn btn-secondary" href="{{ route('customers.import.create', $customer) }}">Zurück</a>
        </form>
    </div>
@endsection
