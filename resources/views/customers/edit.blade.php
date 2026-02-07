@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>Kunde bearbeiten</h2>
        <form method="POST" action="{{ route('customers.update', $customer) }}">
            @csrf
            @method('PUT')
            @include('customers._form', ['customer' => $customer])
            <div style="margin-top: 16px;">
                <button class="btn" type="submit">Aktualisieren</button>
                <a class="btn btn-secondary" href="{{ route('customers.show', $customer) }}">Abbrechen</a>
            </div>
        </form>
    </div>
@endsection
