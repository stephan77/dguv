<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1, h2, h3 { margin: 0 0 8px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th, td { border: 1px solid #cbd5f5; padding: 6px; text-align: left; }
        .status-ok { color: #15803d; font-weight: bold; }
        .status-fail { color: #b91c1c; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Kundenbericht</h1>
    <p><strong>{{ $customer->company }}</strong></p>
    <p>{{ $customer->street }}, {{ $customer->zip }} {{ $customer->city }}</p>
    <p>{{ $customer->email }} · {{ $customer->phone }}</p>

    @foreach ($customer->devices as $device)
        <h2>Gerät: {{ $device->name }} ({{ $device->inventory_number }})</h2>
        <p>Hersteller: {{ $device->manufacturer }} | Modell: {{ $device->model }} | Seriennummer: {{ $device->serial }}</p>
        <p>Nächste Prüfung: {{ optional($device->next_inspection)->format('d.m.Y') }}</p>

        <table>
            <thead>
                <tr>
                    <th>Prüfdatum</th>
                    <th>Prüfer</th>
                    <th>Norm</th>
                    <th>Status</th>
                    <th>Messwerte</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($device->inspections as $inspection)
                    <tr>
                        <td>{{ $inspection->inspection_date->format('d.m.Y') }}</td>
                        <td>{{ $inspection->inspector }}</td>
                        <td>{{ $inspection->standard }}</td>
                        <td class="{{ $inspection->passed ? 'status-ok' : 'status-fail' }}">
                            {{ $inspection->passed ? 'Bestanden' : 'Nicht bestanden' }}
                        </td>
                        <td>
                            @foreach ($inspection->measurements as $measurement)
                                <div><strong>{{ $measurement->test_type }}</strong></div>
                                <div class="{{ $measurement->rpe_result === 'nicht bestanden' ? 'status-fail' : '' }}">RPE: {{ $measurement->rpe }} ({{ $measurement->rpe_result }})</div>
                                <div class="{{ $measurement->riso_result === 'nicht bestanden' ? 'status-fail' : '' }}">RISO: {{ $measurement->riso }} ({{ $measurement->riso_result }})</div>
                                <div class="{{ $measurement->leakage_result === 'nicht bestanden' ? 'status-fail' : '' }}">Leakage: {{ $measurement->leakage }} ({{ $measurement->leakage_result }})</div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
