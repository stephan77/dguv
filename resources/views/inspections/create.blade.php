@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-xl font-semibold mb-6">
            Prüfung für {{ $device->name }} anlegen
        </h2>

        <form method="POST"
              action="{{ route('devices.inspections.store', $device) }}"
              class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label for="inspection_date" class="block text-sm font-medium text-slate-700 mb-1">
                        Prüfdatum
                    </label>
                    <input id="inspection_date"
                           type="date"
                           name="inspection_date"
                           value="{{ old('inspection_date', now()->format('Y-m-d')) }}"
                           required
                           class="w-full rounded-xl border-slate-300 focus:border-slate-500 focus:ring-slate-500">
                </div>

                <div>
                    <label for="inspector" class="block text-sm font-medium text-slate-700 mb-1">
                        Prüfer
                    </label>
                    <input id="inspector"
                           name="inspector"
                           value="{{ old('inspector') }}"
                           required
                           class="w-full rounded-xl border-slate-300 focus:border-slate-500 focus:ring-slate-500">
                </div>

                <div>
                    <label for="standard" class="block text-sm font-medium text-slate-700 mb-1">
                        Norm
                    </label>
                    <input id="standard"
                           name="standard"
                           value="{{ old('standard', 'DGUV V3') }}"
                           required
                           class="w-full rounded-xl border-slate-300 focus:border-slate-500 focus:ring-slate-500">
                </div>

                <div>
                    <label for="passed" class="block text-sm font-medium text-slate-700 mb-1">
                        Bestanden?
                    </label>
                    <select id="passed"
                            name="passed"
                            required
                            class="w-full rounded-xl border-slate-300 focus:border-slate-500 focus:ring-slate-500">
                        <option value="1">Bestanden</option>
                        <option value="0">Nicht bestanden</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">
                        Notizen
                    </label>
                    <textarea id="notes"
                              name="notes"
                              rows="3"
                              class="w-full rounded-xl border-slate-300 focus:border-slate-500 focus:ring-slate-500">{{ old('notes') }}</textarea>
                </div>

            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit"
                        class="inline-flex items-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                    Prüfung speichern
                </button>

                <a href="{{ route('devices.show', $device) }}"
                   class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Abbrechen
                </a>
            </div>

        </form>
    </div>

</div>
@endsection