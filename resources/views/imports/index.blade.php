@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-xl font-semibold mb-2">CSV Import</h2>
        <p class="text-sm text-slate-600 mb-6">
            Wählen Sie einen Kunden aus, um den ST725 CSV Import zu starten.
        </p>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-slate-200 text-slate-600">
                        <th class="py-3 pr-4 font-medium">Firma</th>
                        <th class="py-3 pr-4 font-medium">Ort</th>
                        <th class="py-3 pr-4 font-medium"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 pr-4 font-medium text-slate-900">
                                {{ $customer->company }}
                            </td>
                            <td class="py-3 pr-4 text-slate-600">
                                {{ $customer->zip }} {{ $customer->city }}
                            </td>
                            <td class="py-3 pr-4">
                                <a href="{{ route('customers.import.create', $customer) }}"
                                   class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                                    Import starten
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-6 text-center text-slate-500">
                                Keine Kunden vorhanden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection