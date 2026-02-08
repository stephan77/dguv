@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-xl font-semibold">{{ $customer->company }}</h2>
                <p class="text-sm text-slate-500">
                    {{ $customer->street }}, {{ $customer->zip }} {{ $customer->city }}
                </p>
                <p class="text-sm text-slate-500">
                    {{ $customer->email }} · {{ $customer->phone }}
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('customers.edit', $customer) }}"
                   class="px-4 py-2 bg-slate-200 text-slate-800 rounded-xl text-sm hover:bg-slate-300">
                    Bearbeiten
                </a>

                <form method="POST" action="{{ route('customers.destroy', $customer) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-xl text-sm hover:bg-red-700">
                        Löschen
                    </button>
                </form>

                <a href="{{ route('customers.report', $customer) }}"
                   class="px-4 py-2 bg-slate-900 text-white rounded-xl text-sm hover:bg-slate-800">
                    PDF Bericht
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Geräte</h3>
            <a href="{{ route('customers.devices.create', $customer) }}"
               class="px-4 py-2 bg-slate-900 text-white rounded-xl text-sm hover:bg-slate-800">
                Neues Gerät
            </a>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-slate-500">
                    <th class="text-left py-2 border-b">Inventar</th>
                    <th class="text-left py-2 border-b">Gerät</th>
                    <th class="text-left py-2 border-b">Nächste Prüfung</th>
                    <th class="text-left py-2 border-b">Prüfungen</th>
                    <th class="py-2 border-b"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customer->devices as $device)
                    <tr>
                        <td class="py-2 border-b">{{ $device->inventory_number }}</td>
                        <td class="py-2 border-b">{{ $device->name }}</td>
                        <td class="py-2 border-b">
                            {{ optional($device->next_inspection)->format('d.m.Y') }}
                        </td>
                        <td class="py-2 border-b">{{ $device->inspections->count() }}</td>
                        <td class="py-2 border-b text-right">
                            <a href="{{ route('devices.show', $device) }}"
                               class="px-3 py-1 bg-slate-200 rounded-lg text-xs">
                                Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-slate-400">
                            Noch keine Geräte.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection