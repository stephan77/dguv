@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>CSV Import für {{ $customer->company }}</h2>
        <form method="POST" action="{{ route('customers.import.preview', $customer) }}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 12px;">
                <label for="csv_file">CSV Datei (Benning ST725)</label>
                <input id="csv_file" type="file" name="csv_file" required>
                @error('csv_file')<div class="status-fail">{{ $message }}</div>@enderror
            </div>
            <button class="btn" type="submit">Vorschau anzeigen</button>
        </form>
    </div>
@endsection
