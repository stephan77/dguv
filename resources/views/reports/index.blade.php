@extends('layouts.app')

@section('content')
<div class="bg-white shadow-sm rounded-2xl border border-slate-200">
    <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Berichte</h2>
            <p class="text-sm text-slate-500">PDF-Komplettberichte pro Kunde herunterladen.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Firma
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Ort
                    </th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($customers as $customer)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            {{ $customer->company }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $customer->zip }} {{ $customer->city }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('customers.report', $customer) }}"
                               class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-slate-800">
                                PDF Bericht
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-6 text-center text-sm text-slate-500">
                            Keine Kunden vorhanden.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection