@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>Gerät bearbeiten</h2>
        <form method="POST" action="{{ route('devices.update', $device) }}">
            @csrf
            @method('PUT')
            @include('devices._form', ['device' => $device])
            <div style="margin-top: 16px;">
                <button class="btn" type="submit">Aktualisieren</button>
                <a class="btn btn-secondary" href="{{ route('devices.show', $device) }}">Abbrechen</a>
            </div>
        </form>
    </div>
@endsection
