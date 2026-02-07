@extends('layouts.app')

@section('content')
    <div class="grid grid-2">
        <div class="card">
            <h2>Willkommen!</h2>
            <p>Verwalten Sie Kunden, Geräte und Prüfungen zentral an einem Ort.</p>
        </div>
        <div class="card">
            <h3>Schnellaktionen</h3>
            <p>
                <a class="btn" href="{{ route('customers.create') }}">Neuen Kunden anlegen</a>
            </p>
        </div>
    </div>
@endsection
