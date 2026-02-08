<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="utf-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
    h1 { margin-bottom: 6px; }
    h2 { margin-top: 18px; margin-bottom: 6px; }
    h3 { margin-top: 12px; margin-bottom: 4px; }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 12px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 5px;
        text-align: left;
    }

    th {
        background: #eee;
    }

    .ok { color: #15803d; font-weight: bold; }
    .fail { color: #b91c1c; font-weight: bold; }
</style>
</head>
<body>

<h1>DGUV Prüfprotokoll</h1>

<h2>{{ $customer->company }}</h2>
<p>
{{ $customer->street }}, {{ $customer->zip }} {{ $customer->city }}<br>
{{ $customer->email }} · {{ $customer->phone }}
</p>

@foreach ($customer->devices as $device)

    <h2>Gerät: {{ $device->name }} ({{ $device->inventory_number }})</h2>

    <table>
        <tr>
            <td><strong>Hersteller</strong></td>
            <td>{{ $device->manufacturer }}</td>
            <td><strong>Modell</strong></td>
            <td>{{ $device->model }}</td>
        </tr>
        <tr>
            <td><strong>Seriennummer</strong></td>
            <td>{{ $device->serial }}</td>
            <td><strong>Nächste Prüfung</strong></td>
            <td>{{ optional($device->next_inspection)->format('d.m.Y') }}</td>
        </tr>
    </table>

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
                    {{ $inspection->passed ? 'Bestanden' : 'Nicht bestanden' }}
                </td>
            </tr>
        </table>

@foreach ($inspection->measurements as $m)
@php
    $data = $m->raw_data ?? [];
    $class = $data['class'] ?? 'I';

    $rpe  = floatval(str_replace(',', '.', $data['rpe'] ?? 0));
    $riso = floatval(str_replace(',', '.', $data['riso'] ?? 0));
    $iea  = floatval(str_replace(',', '.', $data['iea'] ?? 0));

    if ($class === 'I') {
        $limit_rpe  = 0.3;
        $limit_riso = 1;
        $limit_iea  = 3.5;
    } else {
        $limit_rpe  = null;
        $limit_riso = 2;
        $limit_iea  = 0.5;
    }

    $rpe_ok  = $class === 'I' ? ($rpe <= $limit_rpe) : null;
    $riso_ok = $riso >= $limit_riso;
    $iea_ok  = $iea <= $limit_iea;
@endphp


        <h3>Sichtprüfung</h3>
        <table>
            <tr>
                <th>Prüfung</th>
                <th>Ergebnis</th>
            </tr>
            <tr>
                <td>Gerät äußerlich in Ordnung</td>
                <td class="{{ ($data['visual_result'] ?? 'bestanden') === 'bestanden' ? 'ok' : 'fail' }}">
                    {{ $data['visual_result'] ?? 'bestanden' }}
                </td>
            </tr>
        </table>


        <h3>Messwerte nach DGUV V3</h3>
        <table>
            <tr>
                <th>Messart</th>
                <th>Wert</th>
                <th>Einheit</th>
                <th>Grenzwert</th>
                <th>Ergebnis</th>
            </tr>

            @if($class === 'I' && !empty($data['rpe']))
            <tr>
                <td>Schutzleiterwiderstand (RPE)</td>
                <td>{{ $data['rpe'] }}</td>
                <td>Ω</td>
                <td>≤ {{ $limit_rpe }}</td>
                <td class="{{ $rpe_ok ? 'ok' : 'fail' }}">
                    {{ $rpe_ok ? 'bestanden' : 'nicht bestanden' }}
                </td>
            </tr>
            @endif

            @if(!empty($data['riso']))
            <tr>
                <td>Isolationswiderstand (RISO)</td>
                <td>{{ $data['riso'] }}</td>
                <td>MΩ</td>
                <td>≥ {{ $limit_riso }}</td>
                <td class="{{ $riso_ok ? 'ok' : 'fail' }}">
                    {{ $riso_ok ? 'bestanden' : 'nicht bestanden' }}
                </td>
            </tr>
            @endif

            @if(!empty($data['iea']))
            <tr>
                <td>Ableitstrom</td>
                <td>{{ $data['iea'] }}</td>
                <td>mA</td>
                <td>≤ {{ $limit_iea }}</td>
                <td class="{{ $iea_ok ? 'ok' : 'fail' }}">
                    {{ $iea_ok ? 'bestanden' : 'nicht bestanden' }}
                </td>
            </tr>
            @endif

        </table>


        <h3>Funktionsprüfung</h3>
        <table>
            <tr>
                <th>Prüfung</th>
                <th>Ergebnis</th>
            </tr>
            <tr>
                <td>Gerät funktioniert ordnungsgemäß</td>
                <td class="{{ ($data['function_result'] ?? 'bestanden') === 'bestanden' ? 'ok' : 'fail' }}">
                    {{ $data['function_result'] ?? 'bestanden' }}
                </td>
            </tr>
        </table>


        <br><br>

        <table>
        <tr>
            <td style="width:50%">
                Prüfer:<br><br><br>
                ___________________________<br>
                {{ $inspection->inspector }}
            </td>

            <td>
                Messgerät:<br>
                BENNING ST725<br>
                Seriennummer: ______________
            </td>
        </tr>
        </table>

@endforeach
@endforeach
@endforeach

</body>
</html>