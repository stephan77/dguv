@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Prüfgeräte</h2>
        <a href="{{ route('test-devices.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded">
            + Neu
        </a>
    </div>

    <table class="w-full border">
        <tr>
            <th>Name</th>
            <th>Seriennummer</th>
            <th>Kalibriert bis</th>
            <th></th>
        </tr>

        @foreach($devices as $d)
        <tr>
            <td>{{ $d->name }}</td>
            <td>{{ $d->serial_number }}</td>
            <td>{{ optional($d->calibrated_until)->format('d.m.Y') }}</td>
            <td>
                <a href="{{ route('test-devices.edit', $d) }}">Bearbeiten</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection