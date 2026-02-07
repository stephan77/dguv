@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content: space-between; align-items:center;">
            <h2>Kunden</h2>
            <a class="btn" href="{{ route('customers.create') }}">Neuer Kunde</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Firma</th>
                    <th>Ansprechpartner</th>
                    <th>Ort</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->company }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->zip }} {{ $customer->city }}</td>
                        <td><a class="btn btn-secondary" href="{{ route('customers.show', $customer) }}">Details</a></td>
                    </tr>
                @empty
                    <tr><td colspan="4">Noch keine Kunden angelegt.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 12px;">{{ $customers->links() }}</div>
    </div>
@endsection
