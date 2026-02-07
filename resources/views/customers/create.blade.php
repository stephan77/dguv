@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>Kunde anlegen</h2>
        <form method="POST" action="{{ route('customers.store') }}">
            @csrf
            @include('customers._form')
            <div style="margin-top: 16px;">
                <button class="btn" type="submit">Speichern</button>
                <a class="btn btn-secondary" href="{{ route('customers.index') }}">Abbrechen</a>
            </div>
        </form>
    </div>
@endsection
