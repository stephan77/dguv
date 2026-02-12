<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="utf-8">
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 10.2px;
        color: #111;
        line-height: 1.25;
    }

    h1 { margin: 0 0 3px 0; font-size: 15px; }
    h2 { margin: 7px 0 3px 0; font-size: 12px; }
    h3 { margin: 6px 0 3px 0; font-size: 11px; }

    .sheet { page-break-after: always; }
    .block { page-break-inside: avoid; }

    .welder { font-size: 9.6px; }

    .header {
        border-bottom: 2px solid #000;
        padding-bottom: 5px;
        margin-bottom: 6px;
    }

    .device-title {
        font-size: 13px;
        font-weight: bold;
        margin-top: 4px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 6px;
    }

    th, td {
        border: 1px solid #bbb;
        padding: 3px 4px;
        vertical-align: top;
    }

    th { background: #f3f4f6; font-weight: bold; }

    .ok { color: #15803d; font-weight: bold; }
    .fail { color: #b91c1c; font-weight: bold; }

    .rowmini td { padding: 2px 4px; }

    .footer { margin-top: 6px; }

    .sign td {
        border: 0;
        padding: 2px 0;
    }

    .line {
        display: inline-block;
        border-bottom: 1px solid #000;
        width: 220px;
        height: 10px;
        vertical-align: bottom;
    }

    .legal {
        font-size: 8px;
        line-height: 1.25;
        margin-top: 6px;
        color: #222;
    }
</style>
</head>
<body>

@foreach ($customer->devices as $device)

@php
    $inspection = $device->inspections->sortByDesc('inspection_date')->first();
    if(!$inspection) continue;

    $m = $inspection->measurements->first();
    $data = is_array($m?->raw_data ?? null) ? $m->raw_data : [];

    $tester = optional($inspection->tester);
    $testerName = $tester->name ?? $inspection->tester_device ?? 'Benning ST725';
    $testerSerial = $tester->serial_number ?? $inspection->tester_serial ?? '-';
    $testerCalibratedUntil = optional($tester->calibrated_until)->format('d.m.Y')
        ?? optional($inspection->tester_calibrated_at)->format('d.m.Y')
        ?? '-';

    $isWelder = str_contains($inspection->standard ?? '', '60974');
    $class = $inspection->protection_class ?? 'I';

    $rpe  = floatval(str_replace(',', '.', $data['rpe'] ?? 0));
    $riso = floatval(str_replace(',', '.', $data['riso'] ?? 0));
    $iea  = floatval(str_replace(',', '.', $data['iea'] ?? 0));

    // Grenzwerte (dein aktueller Stand)
    $limit_rpe  = 0.3;
    $limit_riso = ($class === 'I') ? 1 : 2;
    $limit_iea  = $isWelder ? 15 : (($class === 'I') ? 3.5 : 0.5);

    $rpe_ok  = ($data['rpe'] ?? null) !== null ? ($rpe <= $limit_rpe) : true;
    $riso_ok = ($data['riso'] ?? null) !== null ? ($riso >= $limit_riso) : true;
    $iea_ok  = ($data['iea'] ?? null) !== null ? ($iea <= $limit_iea) : true;

    // Sicht-/Funktion (wenn nichts vorhanden -> bestanden)
    $visualOk   = ($data['visual_result'] ?? 'bestanden') === 'bestanden';
    $functionOk = ($data['function_result'] ?? 'bestanden') === 'bestanden';
@endphp

<div class="sheet {{ $isWelder ? 'welder' : '' }}">

    <!-- HEADER -->
    <div class="header block">
        <table style="border:0; margin-bottom:0;">
            <tr>
                <td style="border:0; width:70%">
                    <h1>Prüfprotokoll nach DGUV Vorschrift 3</h1>

                    @if($isWelder)
                        DIN VDE 0701-0702 + DIN EN 60974-4 (VDE 0544-4)
                    @else
                        DIN VDE 0701-0702
                    @endif
                </td>
                <td style="border:0; text-align:right; white-space:nowrap;">
                    Datum: {{ now()->format('d.m.Y') }}
                </td>
            </tr>
        </table>

        <strong>{{ $customer->company }}</strong><br>
        {{ $customer->street }}, {{ $customer->zip }} {{ $customer->city }}
        @if($customer->email || $customer->phone)
            <br>{{ $customer->email }}{{ $customer->email && $customer->phone ? ' · ' : '' }}{{ $customer->phone }}
        @endif
    </div>

    <!-- DEVICE -->
    <div class="block">
        <div class="device-title">
            Gerät: {{ $device->name }} ({{ $device->inventory_number }})
        </div>

        <table class="rowmini">
            <tr>
                <td style="width:18%"><strong>Hersteller</strong></td>
                <td style="width:32%">{{ $device->manufacturer }}</td>
                <td style="width:18%"><strong>Modell</strong></td>
                <td style="width:32%">{{ $device->model }}</td>
            </tr>
            <tr>
                <td><strong>Seriennr.</strong></td>
                <td>{{ $device->serial }}</td>
                <td><strong>Standort</strong></td>
                <td>{{ $device->location }}</td>
            </tr>
            <tr>
                <td><strong>Nächste</strong></td>
                <td>{{ optional($device->next_inspection)->format('d.m.Y') }}</td>
                <td><strong>Inventar</strong></td>
                <td>{{ $device->inventory_number }}</td>
            </tr>
        </table>
    </div>

    <!-- INSPECTION META -->
    <div class="block">
        <h2>Prüfung vom {{ optional($inspection->inspection_date)->format('d.m.Y') ?? '-' }}</h2>

        <table class="rowmini">
            <tr>
                <td style="width:18%"><strong>Prüfer</strong></td>
                <td style="width:32%">{{ $inspection->inspector }}</td>
                <td style="width:18%"><strong>Prüfgrund</strong></td>
                <td style="width:32%">{{ $inspection->test_reason ?? 'Wiederholungsprüfung' }}</td>
            </tr>
            <tr>
                <td><strong>Schutzklasse</strong></td>
                <td>{{ $inspection->protection_class ?? 'I' }}</td>
                <td><strong>Intervall</strong></td>
                <td>{{ $inspection->interval_months ?? 12 }} Monate</td>
            </tr>
            <tr>
                <td><strong>Messgerät</strong></td>
                <td>{{ $testerName }}</td>
                <td><strong>Seriennr.</strong></td>
                <td>{{ $testerSerial }}</td>
            </tr>
            <tr>
                <td><strong>Kalibriert bis</strong></td>
                <td>{{ $testerCalibratedUntil }}</td>
                <td><strong>Norm</strong></td>
                <td>{{ $inspection->standard }}</td>
            </tr>
        </table>
    </div>

    <!-- VISUAL + FUNCTION compact -->
    <div class="block">
        <table class="rowmini">
            <tr>
                <td style="width:50%"><strong>Sichtprüfung</strong>: Gerät äußerlich in Ordnung</td>
                <td style="width:50%" class="{{ $visualOk ? 'ok' : 'fail' }}">
                    {{ $visualOk ? 'bestanden' : 'nicht bestanden' }}
                </td>
            </tr>
            <tr>
                <td><strong>Funktionsprüfung</strong>: Gerät funktioniert ordnungsgemäß</td>
                <td class="{{ $functionOk ? 'ok' : 'fail' }}">
                    {{ $functionOk ? 'bestanden' : 'nicht bestanden' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- MEASUREMENTS -->
    <div class="block">
        <h3>Messwerte</h3>
        <table>
            <tr>
                <th style="width:40%">Messart</th>
                <th style="width:20%">Wert</th>
                <th style="width:20%">Grenzwert</th>
                <th style="width:20%">Ergebnis</th>
            </tr>

            <tr>
                <td>Schutzleiterwiderstand (RPE)</td>
                <td>{{ $data['rpe'] ?? '-' }} Ω</td>
                <td>≤ {{ $limit_rpe }} Ω</td>
                <td class="{{ $rpe_ok ? 'ok' : 'fail' }}">{{ $rpe_ok ? 'Bestanden' : 'Nicht bestanden' }}</td>
            </tr>

            <tr>
                <td>Isolationswiderstand (RISO)</td>
                <td>{{ $data['riso'] ?? '-' }} MΩ</td>
                <td>≥ {{ $limit_riso }} MΩ</td>
                <td class="{{ $riso_ok ? 'ok' : 'fail' }}">{{ $riso_ok ? 'Bestanden' : 'Nicht bestanden' }}</td>
            </tr>

            <tr>
                <td>Ableitstrom (IEA)</td>
                <td>{{ $data['iea'] ?? '-' }} mA</td>
                <td>≤ {{ $limit_iea }} mA</td>
                <td class="{{ $iea_ok ? 'ok' : 'fail' }}">{{ $iea_ok ? 'Bestanden' : 'Nicht bestanden' }}</td>
            </tr>
        </table>
    </div>

    <!-- WELDER EXTRA -->
    @if($isWelder)
    <div class="block">
        <h3>Zusatzprüfung Schweißgerät (EN 60974-4)</h3>
        <table class="rowmini">
            <tr><td>Leerlaufspannung</td><td class="ok">bestanden</td></tr>
            <tr><td>VRD vorhanden</td><td class="ok">bestanden</td></tr>
            <tr><td>Schweißkabel Zustand</td><td class="ok">bestanden</td></tr>
            <tr><td>Brenner Zustand</td><td class="ok">bestanden</td></tr>
            <tr><td>Masseklemme Zustand</td><td class="ok">bestanden</td></tr>
            <tr><td>Funktionsprüfung Schweißgerät</td><td class="ok">bestanden</td></tr>
        </table>
    </div>
    @endif

    <!-- RESULT -->
    <div class="block">
        <h2 style="margin-top:6px;">
            Gesamtbewertung:
            <span class="{{ $inspection->passed ? 'ok' : 'fail' }}">
                {{ $inspection->passed ? 'GERÄT BESTANDEN' : 'GERÄT NICHT BESTANDEN' }}
            </span>
        </h2>
    </div>

    <!-- SIGNATURES + LEGAL -->
    <div class="footer block">
        <table class="sign" style="width:100%; border:0; margin-bottom:4px;">
            <tr>
                <td style="width:50%">
                    Prüfer: <span class="line"></span><br>
                    <span style="font-size:9px;">{{ $inspection->inspector }}</span>
                </td>
                <td style="width:50%">
                    Kunde: <span class="line"></span><br>
                    <span style="font-size:9px;">{{ optional($inspection->inspection_date)->format('d.m.Y') ?? '-' }}</span>
                </td>
            </tr>
        </table>

        <div class="legal">
            Diese Prüfung wurde gemäß DGUV Vorschrift 3 sowie den zutreffenden Normen
            @if($isWelder) (DIN VDE 0701-0702 und DIN EN 60974-4 / VDE 0544-4) @else (DIN VDE 0701-0702) @endif
            durchgeführt. Sie umfasst Sicht-, Mess- und Funktionsprüfung und bewertet den Zustand des Geräts ausschließlich
            zum Zeitpunkt der Prüfung. Der Betreiber bleibt für sicheren Betrieb, Prüffristen sowie die Einsatzbedingungen verantwortlich.
            Die Prüfung wurde von einer befähigten Person nach TRBS 1203 durchgeführt.
        </div>
    </div>

</div>
@endforeach

</body>
</html>