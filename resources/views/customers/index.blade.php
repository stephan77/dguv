@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-slate-800">Kunden</h2>

            <a href="{{ route('customers.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800 transition touch-target">
                Neuer Kunde
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm responsive-table-card tablet-compact">
                <thead>
                    <tr class="text-left text-slate-500 border-b">
                        <th class="pb-3 font-medium">Firma</th>
                        <th class="pb-3 font-medium">Ansprechpartner</th>
                        <th class="pb-3 font-medium">Ort</th>
                        <th class="pb-3"></th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 font-medium text-slate-800" data-label="Firma">
                                {{ $customer->company }}
                            </td>

                            <td class="py-3 text-slate-600" data-label="Ansprechpartner">
                                {{ $customer->name }}
                            </td>

                            <td class="py-3 text-slate-600" data-label="Ort">
                                {{ $customer->zip }} {{ $customer->city }}
                            </td>

                            <td class="py-3 text-right" data-label="Aktion">
                                <a href="{{ route('customers.show', $customer) }}"
                                   class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-100 transition touch-target">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">
                                Noch keine Kunden angelegt.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $customers->links() }}
        </div>

    </div>
</div>
@endsection