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

<h1>DGUV Prüfprotokoll</h1>

<div class="meta">
    <strong>{{ $customer->company }}</strong><br>
    {{ $customer->street }}, {{ $customer->zip }} {{ $customer->city }}<br>
    {{ $customer->email }} · {{ $customer->phone }}
</div>

@foreach ($customer->devices as $device)
    <div class="device-box">

        <h2>Gerät: {{ $device->name }} ({{ $device->inventory_number }})</h2>

        <div class="meta">
            Hersteller: {{ $device->manufacturer }} |
            Modell: {{ $device->model }} |
            Seriennummer: {{ $device->serial }}<br>
            Standort: {{ $device->location }}<br>
            Nächste Prüfung: {{ optional($device->next_inspection)->format('d.m.Y') }}
        </div>

        @foreach ($device->inspections as $inspection)
            <h3>Prüfung vom {{ $inspection->inspection_date->format('d.m.Y') }}</h3>

            <table>
                <tr>
                    <th>Prüfer</th>
                    <th>Norm</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>{{ $inspection->inspector }}</td>
                    <td>{{ $inspection->standard }}</td>
                    <td class="{{ $inspection->passed ? 'ok' : 'fail' }}">
                        {{ $inspection->passed ? 'BESTANDEN' : 'NICHT BESTANDEN' }}
                    </td>
                </tr>
            </table>

            @foreach ($inspection->measurements as $measurement)
                @php $data = $measurement->raw_data ?? []; @endphp

                <div class="section-title">Messwerte (ST725)</div>

                <table>
                    <tr>
                        <th>Messart</th>
                        <th>Wert</th>
                        <th>Einheit</th>
                        <th>Ergebnis</th>
                    </tr>

                    <tr>
                        <td>Schutzleiterwiderstand (RPE)</td>
                        <td>{{ $data['RPE Wert'] ?? '-' }}</td>
                        <td>{{ $data['RPE Einheit'] ?? '-' }}</td>
                        <td>{{ $data['RPE Ergebnis'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Ableitstrom (IPE)</td>
                        <td>{{ $data['IPE Wert'] ?? '-' }}</td>
                        <td>{{ $data['IPE Einheit'] ?? '-' }}</td>
                        <td>{{ $data['IPE Ergebnis'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Berührungsstrom (IBer)</td>
                        <td>{{ $data['IBer Wert'] ?? '-' }}</td>
                        <td>{{ $data['IBer Einheit'] ?? '-' }}</td>
                        <td>{{ $data['IBer Ergebnis'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Ersatzableitstrom (IEA)</td>
                        <td>{{ $data['IEA Wert'] ?? '-' }}</td>
                        <td>{{ $data['IEA Einheit'] ?? '-' }}</td>
                        <td>{{ $data['IEA Ergebnis'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Isolationswiderstand (RISO)</td>
                        <td>{{ $data['RISO Wert'] ?? '-' }}</td>
                        <td>{{ $data['RISO Einheit'] ?? '-' }}</td>
                        <td>{{ $data['RISO Ergebnis'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Prüfspannung RISO</td>
                        <td>{{ $data['RISO Spannung'] ?? '-' }}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Kabelprüfung</td>
                        <td>{{ $data['Kabel Wert'] ?? '-' }}</td>
                        <td>{{ $data['Kabel Einheit'] ?? '-' }}</td>
                        <td>{{ $data['Kabel Ergebnis'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Sichtprüfung</td>
                        <td></td>
                        <td></td>
                        <td>{{ $data['Sichtprüfung Ergebnis'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>FI/RCD Test</td>
                        <td>{{ $data['FI/RCD Wert'] ?? '-' }}</td>
                        <td>{{ $data['FI/RCD Einheit'] ?? '-' }}</td>
                        <td>{{ $data['FI/RCD Ergebnis'] ?? '-' }}</td>
                    </tr>

                </table>
            @endforeach
        @endforeach

    </div>
@endforeach

</body>
</html>