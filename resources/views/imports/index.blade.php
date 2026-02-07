@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>CSV Import</h2>
        <p>Wählen Sie einen Kunden aus, um den ST725 CSV Import zu starten.</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Firma</th>
                    <th>Ort</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->company }}</td>
                        <td>{{ $customer->zip }} {{ $customer->city }}</td>
                        <td><a class="btn btn-secondary" href="{{ route('customers.import.create', $customer) }}">Import starten</a></td>
                    </tr>
                @empty
                    <tr><td colspan="3">Keine Kunden vorhanden.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
