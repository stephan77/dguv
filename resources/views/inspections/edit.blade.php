@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-6">
        Prüfung bearbeiten
    </h2>

    @php
        $measurement = $inspection->measurements->first();
    @endphp

    <form method="POST"
          action="{{ route('inspections.update', $inspection) }}">
        @csrf
        @method('PUT')

        {{-- ALLGEMEIN --}}
        <div class="mb-6">
            <label class="block mb-2 font-medium">Kommentar</label>
            <textarea name="notes"
                      class="w-full border rounded p-2"
                      rows="3">{{ $inspection->notes }}</textarea>
        </div>

        <hr class="my-6">

        <h3 class="font-semibold mb-4">Messwerte</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block mb-2">RPE</label>
                <input type="text"
                       name="rpe"
                       value="{{ $measurement->rpe ?? '' }}"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block mb-2">RPE Ergebnis</label>
                <select name="rpe_result" class="w-full border rounded p-2">
                    <option value="bestanden" @selected(($measurement->rpe_result ?? '')=='bestanden')>Bestanden</option>
                    <option value="nicht bestanden" @selected(($measurement->rpe_result ?? '')=='nicht bestanden')>Nicht bestanden</option>
                </select>
            </div>

            <div>
                <label class="block mb-2">RISO</label>
                <input type="text"
                       name="riso"
                       value="{{ $measurement->riso ?? '' }}"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block mb-2">RISO Ergebnis</label>
                <select name="riso_result" class="w-full border rounded p-2">
                    <option value="bestanden" @selected(($measurement->riso_result ?? '')=='bestanden')>Bestanden</option>
                    <option value="nicht bestanden" @selected(($measurement->riso_result ?? '')=='nicht bestanden')>Nicht bestanden</option>
                </select>
            </div>

            <div>
                <label class="block mb-2">Leakage</label>
                <input type="text"
                       name="leakage"
                       value="{{ $measurement->leakage ?? '' }}"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block mb-2">Leakage Ergebnis</label>
                <select name="leakage_result" class="w-full border rounded p-2">
                    <option value="bestanden" @selected(($measurement->leakage_result ?? '')=='bestanden')>Bestanden</option>
                    <option value="nicht bestanden" @selected(($measurement->leakage_result ?? '')=='nicht bestanden')>Nicht bestanden</option>
                </select>
            </div>

        </div>

        <button class="w-full mt-6 py-3 bg-green-600 text-white rounded-xl">
            Änderungen speichern
        </button>
    </form>
</div>
@endsection