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
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

    <div>
        <label class="block mb-2 font-medium">Prüfdatum</label>
        <input type="date"
               name="inspection_date"
               value="{{ optional($inspection->inspection_date)->format('Y-m-d') }}"
               class="w-full border rounded p-2">
    </div>

    <div>
        <label class="block mb-2 font-medium">Prüfer</label>
        <input type="text"
               name="inspector"
               value="{{ $inspection->inspector }}"
               class="w-full border rounded p-2">
    </div>

    <div class="md:col-span-2">
        <label class="block mb-2 font-medium">Gesamtergebnis</label>
        <select name="passed" class="w-full border rounded p-2">
            <option value="1" @selected($inspection->passed)>Bestanden</option>
            <option value="0" @selected(!$inspection->passed)>Nicht bestanden</option>
        </select>
    </div>
    <div class="md:col-span-2">
    <label class="flex items-center gap-2">
        <input type="checkbox"
               name="is_welder"
               value="1"
               {{ $inspection->standard === 'DIN EN 60974-4' ? 'checked' : '' }}>
        <span>Schweißgerät (DIN EN 60974-4)</span>
    </label>
</div>

</div>
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
<hr class="my-6">

<h3 class="font-semibold mb-4">Prüfdetails</h3>
<div>
    <label class="block mb-2 font-medium">Prüfgerät</label>
    <select name="test_device_id" class="w-full border rounded p-2">
        <option value="">–</option>
        @forelse(($testDevices ?? collect()) as $td)
            <option value="{{ $td->id }}"
                @selected($inspection->test_device_id == $td->id)>
                {{ $td->name }} – {{ $td->serial_number }}
            </option>
        @empty
            <option value="" disabled>Keine Prüfgeräte vorhanden</option>
        @endforelse
    </select>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

    <div>
        <label class="block mb-2 font-medium">Prüfgrund</label>
        <select name="test_reason" class="w-full border rounded p-2">
            <option value="">–</option>
            <option value="Erstprüfung" @selected($inspection->test_reason=='Erstprüfung')>Erstprüfung</option>
            <option value="Wiederholungsprüfung" @selected($inspection->test_reason=='Wiederholungsprüfung')>Wiederholungsprüfung</option>
            <option value="Reparaturprüfung" @selected($inspection->test_reason=='Reparaturprüfung')>Nach Reparatur</option>
        </select>
    </div>

    <div>
        <label class="block mb-2 font-medium">Schutzklasse</label>
        <select name="protection_class" class="w-full border rounded p-2">
            <option value="">–</option>
            <option value="SK I" @selected($inspection->protection_class=='SK I')>SK I</option>
            <option value="SK II" @selected($inspection->protection_class=='SK II')>SK II</option>
            <option value="SK III" @selected($inspection->protection_class=='SK III')>SK III</option>
        </select>
    </div>

    <div>
        <label class="block mb-2 font-medium">Prüfgerät</label>
        <input type="text"
               name="tester_device"
               value="{{ $inspection->tester_device }}"
               class="w-full border rounded p-2"
               placeholder="z.B. BENNING ST725">
    </div>

    <div>
        <label class="block mb-2 font-medium">Seriennummer Prüfgerät</label>
        <input type="text"
               name="tester_serial"
               value="{{ $inspection->tester_serial }}"
               class="w-full border rounded p-2">
    </div>

    <div>
        <label class="block mb-2 font-medium">Kalibriert am</label>
        <input type="date"
               name="tester_calibrated_at"
               value="{{ optional($inspection->tester_calibrated_at)->format('Y-m-d') }}"
               class="w-full border rounded p-2">
    </div>

    <div>
        <label class="block mb-2 font-medium">Prüfintervall (Monate)</label>
        <input type="number"
               name="interval_months"
               value="{{ $inspection->interval_months }}"
               class="w-full border rounded p-2"
               placeholder="12">
    </div>

</div>
        <button class="w-full mt-6 py-3 bg-green-600 text-white rounded-xl">
            Änderungen speichern
        </button>
    </form>
</div>
@endsection