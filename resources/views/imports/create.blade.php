@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-xl font-semibold mb-6">
            CSV Import für {{ $customer->company }}
        </h2>

        <form method="POST"
              action="{{ route('customers.import.preview', $customer) }}"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            <div>
                <label for="csv_file" class="block text-sm font-medium text-slate-700 mb-2">
                    CSV Datei (Benning ST725)
                </label>

                <input
                    id="csv_file"
                    type="file"
                    name="csv_file"
                    required
                    class="block w-full text-sm text-slate-700
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-xl file:border-0
                           file:text-sm file:font-medium
                           file:bg-slate-100 file:text-slate-700
                           hover:file:bg-slate-200
                           border border-slate-300 rounded-xl p-2"
                >

                @error('csv_file')
                    <div class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="inline-flex items-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                    Vorschau anzeigen
                </button>
            </div>

        </form>
    </div>

</div>
@endsection