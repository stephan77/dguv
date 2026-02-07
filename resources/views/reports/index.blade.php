@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>Berichte</h2>
        <p>PDF-Komplettberichte pro Kunde herunterladen.</p>
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
                        <td><a class="btn" href="{{ route('customers.report', $customer) }}">PDF Bericht</a></td>
                    </tr>
                @empty
                    <tr><td colspan="3">Keine Kunden vorhanden.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
