@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>Gerät für {{ $customer->company }} anlegen</h2>
        <form method="POST" action="{{ route('customers.devices.store', $customer) }}">
            @csrf
            @include('devices._form')
            <div style="margin-top: 16px;">
                <button class="btn" type="submit">Speichern</button>
                <a class="btn btn-secondary" href="{{ route('customers.show', $customer) }}">Abbrechen</a>
            </div>
        </form>
    </div>
@endsection
