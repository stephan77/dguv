@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-xl font-semibold mb-6">Import Vorschau</h2>

        <form method="POST" action="{{ route('customers.import.store', $customer) }}">
            @csrf

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left border-b border-slate-200 text-slate-600">
                            <th class="py-3 pr-4 font-medium">Speicher Nr</th>
                            <th class="py-3 pr-4 font-medium">Bezeichnung</th>
                            <th class="py-3 pr-4 font-medium">Prüfergebnis</th>
                            <th class="py-3 pr-4 font-medium">Prüfdatum</th>
                            <th class="py-3 pr-4 font-medium">Gerät zuordnen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($rows as $index => $row)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 pr-4">{{ $row['storage_number'] }}</td>
                                <td class="py-3 pr-4">{{ $row['description'] }}</td>
                                <td class="py-3 pr-4">{{ $row['result'] }}</td>
                                <td class="py-3 pr-4">{{ $row['inspection_date'] }}</td>
                                <td class="py-3 pr-4">
                                    <select name="device_ids[{{ $index }}]"
                                        class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
                                        <option value="">-- Gerät wählen --</option>
                                        @foreach ($devices as $device)
                                            <option value="{{ $device->id }}">
                                                {{ $device->inventory_number }} - {{ $device->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-500">
                                    Keine Daten gefunden.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-xl bg-slate-900 px-5 py-2 text-sm font-medium text-white hover:bg-slate-700">
                    Import bestätigen
                </button>

                <a href="{{ route('customers.import.create', $customer) }}"
                   class="inline-flex items-center rounded-xl border border-slate-300 px-5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                    Zurück
                </a>
            </div>
        </form>
    </div>

</div>
@endsection