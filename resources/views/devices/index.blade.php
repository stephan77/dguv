@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Geräteübersicht</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Inventar</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Gerät</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Kunde</th>
                        <th class="text-left px-4 py-3 font-medium text-slate-600">Nächste Prüfung</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($devices as $device)
                        <tr>
                            <td class="px-4 py-3 font-medium">
                                {{ $device->inventory_number }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $device->name }}
                            </td>

                            <td class="px-4 py-3 text-slate-600">
                                {{ $device->customer->company }}
                            </td>

                            <td class="px-4 py-3">
                                {{ optional($device->next_inspection)->format('d.m.Y') }}
                            </td>

                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('devices.show', $device) }}"
                                   class="px-3 py-1.5 text-xs rounded-lg border border-slate-300 hover:bg-slate-50">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">
                                Keine Geräte vorhanden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $devices->links() }}
        </div>
    </div>

</div>
@endsection