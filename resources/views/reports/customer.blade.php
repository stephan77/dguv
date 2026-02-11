<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h1 {
            margin-bottom: 6px;
        }

        h2 {
            margin-top: 22px;
            margin-bottom: 4px;
        }

        h3 {
            margin-top: 14px;
            margin-bottom: 6px;
        }

        .meta {
            margin-bottom: 12px;
        }

        .device-box {
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f1f5f9;
            font-weight: bold;
        }

        .ok {
            color: #15803d;
            font-weight: bold;
        }

        .fail {
            color: #b91c1c;
            font-weight: bold;
        }

        .section-title {
            margin-top: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>DGUV V3 Prüfprotokoll</h1>

<div class="meta">
    <strong>{{ $customer->company }}</strong><br>
    {{ $customer->street }}, {{ $customer->zip }} {{ $customer->city }}<br>
    {{ $customer->email }} · {{ $customer->phone }}
</div>

@foreach ($customer->devices as $device)
<div class="device-box" style="page-break-after: always;">

    <h2>{{ $device->name }} – {{ $device->inventory_number }}</h2>

    <table>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>Seriennummer</th>
            <th>Standort</th>
        </tr>
        <tr>
            <td>{{ $device->manufacturer }}</td>
            <td>{{ $device->model }}</td>
            <td>{{ $device->serial }}</td>
            <td>{{ $device->location }}</td>
        </tr>
    </table>

    <br>

    @php
        $inspection = $device->inspections->first();
    @endphp

    @if($inspection)

    <!-- GROSSE AMPEL -->
    <div style="text-align:center; font-size:22px; margin:15px 0;">
        <strong>Status:
        <span class="{{ $inspection->passed ? 'ok' : 'fail' }}">
            {{ $inspection->passed ? 'BESTANDEN' : 'NICHT BESTANDEN' }}
        </span>
        </strong>
    </div>

    <!-- PRÜFDATEN -->
    <table>
        <tr>
            <th>Prüfdatum</th>
            <th>Prüfer</th>
            <th>Norm</th>
            <th>Schutzklasse</th>
        </tr>
        <tr>
            <td>{{ $inspection->inspection_date->format('d.m.Y') }}</td>
            <td>{{ $inspection->inspector }}</td>
            <td>{{ $inspection->standard }}</td>
            <td>{{ $inspection->protection_class ?? '-' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Prüfgrund</th>
            <th>Prüfintervall</th>
            <th>Nächste Prüfung</th>
        </tr>
        <tr>
            <td>{{ $inspection->test_reason ?? 'Wiederholungsprüfung' }}</td>
            <td>{{ $inspection->interval_months ?? 12 }} Monate</td>
            <td>{{ optional($device->next_inspection)->format('d.m.Y') }}</td>
        </tr>
    </table>

    <!-- MESSGERÄT -->
    <h3>Messgerät</h3>
    <table>
        <tr>
            <th>Gerät</th>
            <th>Seriennummer</th>
            <th>Kalibriert bis</th>
        </tr>
        <tr>
            <td>{{ $inspection->tester_device ?? 'ST725' }}</td>
            <td>{{ $inspection->tester_serial ?? '-' }}</td>
            <td>{{ optional($inspection->tester_calibrated_at)->format('d.m.Y') ?? '-' }}</td>
        </tr>
    </table>

    <!-- MESSWERTE -->
    @foreach ($inspection->measurements as $measurement)
        @php $data = $measurement->raw_data ?? []; @endphp

        <h3>Messwerte</h3>

        <table>
            <tr>
                <th>Messart</th>
                <th>Wert</th>
                <th>Einheit</th>
                <th>Ergebnis</th>
            </tr>

            <tr>
                <td>Schutzleiterwiderstand</td>
                <td>{{ $data['RPE Wert'] ?? '-' }}</td>
                <td>{{ $data['RPE Einheit'] ?? '-' }}</td>
                <td>{{ $data['RPE Ergebnis'] ?? '-' }}</td>
            </tr>

            <tr>
                <td>Isolationswiderstand</td>
                <td>{{ $data['RISO Wert'] ?? '-' }}</td>
                <td>{{ $data['RISO Einheit'] ?? '-' }}</td>
                <td>{{ $data['RISO Ergebnis'] ?? '-' }}</td>
            </tr>

            <tr>
                <td>Ableitstrom</td>
                <td>{{ $data['IPE Wert'] ?? '-' }}</td>
                <td>{{ $data['IPE Einheit'] ?? '-' }}</td>
                <td>{{ $data['IPE Ergebnis'] ?? '-' }}</td>
            </tr>

            <tr>
                <td>Sichtprüfung</td>
                <td></td>
                <td></td>
                <td>{{ $data['Sichtprüfung Ergebnis'] ?? '-' }}</td>
            </tr>
        </table>
    @endforeach

    <!-- KOMMENTAR -->
    @if($inspection->notes)
        <h3>Bemerkung</h3>
        <p>{{ $inspection->notes }}</p>
    @endif

    @endif

</div>
@endforeach

</body>
</html>