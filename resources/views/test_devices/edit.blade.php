@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-6">Prüfgerät bearbeiten</h2>

    <form method="POST" action="{{ route('test-devices.update', $testDevice) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-2 font-medium">Gerätename</label>
            <input type="text" name="name"
                   value="{{ old('name', $testDevice->name) }}"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium">Seriennummer</label>
            <input type="text" name="serial_number"
                   value="{{ old('serial_number', $testDevice->serial_number) }}"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium">Kalibriert bis</label>
            <input type="date" name="calibrated_until"
                   value="{{ old('calibrated_until', optional($testDevice->calibrated_until)->format('Y-m-d')) }}"
                   class="w-full border rounded p-2">
        </div>

        <button class="w-full bg-green-600 text-white py-3 rounded">
            Speichern
        </button>
    </form>

</div>
@endsection
