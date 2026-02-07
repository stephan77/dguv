@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>Prüfung für {{ $device->name }} anlegen</h2>
        <form method="POST" action="{{ route('devices.inspections.store', $device) }}">
            @csrf
            <div class="grid grid-2">
                <div>
                    <label for="inspection_date">Prüfdatum</label>
                    <input id="inspection_date" type="date" name="inspection_date" value="{{ old('inspection_date', now()->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label for="inspector">Prüfer</label>
                    <input id="inspector" name="inspector" value="{{ old('inspector') }}" required>
                </div>
                <div>
                    <label for="standard">Norm</label>
                    <input id="standard" name="standard" value="{{ old('standard', 'DGUV V3') }}" required>
                </div>
                <div>
                    <label for="passed">Bestanden?</label>
                    <select id="passed" name="passed" required>
                        <option value="1">Bestanden</option>
                        <option value="0">Nicht bestanden</option>
                    </select>
                </div>
                <div>
                    <label for="notes">Notizen</label>
                    <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div style="margin-top: 16px;">
                <button class="btn" type="submit">Prüfung speichern</button>
                <a class="btn btn-secondary" href="{{ route('devices.show', $device) }}">Abbrechen</a>
            </div>
        </form>
    </div>
@endsection
