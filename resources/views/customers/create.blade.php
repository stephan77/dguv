@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-xl font-semibold text-slate-800 mb-6">
            Kunde anlegen
        </h2>

        <form method="POST" action="{{ route('customers.store') }}" class="space-y-6">
            @csrf

            @include('customers._form')

            <div class="flex items-center gap-3 pt-4 border-t">
                <button type="submit"
                        class="inline-flex items-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-800 transition">
                    Speichern
                </button>

                <a href="{{ route('customers.index') }}"
                   class="inline-flex items-center rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100 transition">
                    Abbrechen
                </a>
            </div>
        </form>
    </div>

</div>
@endsection