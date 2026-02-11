@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-6">Neues Prüfgerät</h2>

    <form method="POST" action="{{ route('test-devices.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-medium">Gerätename</label>
            <input type="text" name="name"
                   class="w-full border rounded p-2"
                   placeholder="z.B. BENNING ST725">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium">Seriennummer</label>
            <input type="text" name="serial_number"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium">Kalibriert bis</label>
            <input type="date" name="calibrated_until"
                   class="w-full border rounded p-2">
        </div>

        <button class="w-full bg-green-600 text-white py-3 rounded">
            Speichern
        </button>
    </form>

</div>
@endsection