<?php

declare(strict_types=1);

namespace App\Services;

final class St725CsvParser
{
    public function parse(string $content): array
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($content));

        if (!$lines || count($lines) < 2) {
            return [];
        }

        // Header weg (ST725-Export)
        array_shift($lines);

        $rows = [];

        foreach ($lines as $line) {
            if (trim($line) === '') {
                continue;
            }

            $v = str_getcsv($line, ';');

            // ST725 hat je nach Export manchmal weniger/mehr Spalten -> padding
            $v = array_pad($v, 35, null);

            // Schutzklasse ableiten: hat RPE-Wert -> Klasse I, sonst Klasse II
            $class = (!empty($v[4]) || !empty($v[5])) ? 'I' : 'II';

            // RPE: [4]=Ganzteil, [5]=Nachkomma, [6]=Einheit, [7]=Ergebnis
            [$rpeValue, $rpeOp] = $this->parseSplitNumber($v[4] ?? null, $v[5] ?? null);
            $rpeUnit = $this->normUnit($v[6] ?? null);
            $rpeResult = $this->normResult($v[7] ?? null);

            // IEA: [14]=Operator+Ganzteil, [15]=Nachkomma, [16]=Einheit, [17]=Ergebnis
            [$ieaValue, $ieaOp] = $this->parseSplitNumber($v[14] ?? null, $v[15] ?? null);
            $ieaUnit = $this->normUnit($v[16] ?? null);
            $ieaResult = $this->normResult($v[17] ?? null);

            // RISO: [18]=Operator+Ganzteil, [19]=Nachkomma, [20]=Einheit, [21]=Ergebnis, [22]=Spannung (z.B. 500V)
            [$risoValue, $risoOp] = $this->parseSplitNumber($v[18] ?? null, $v[19] ?? null);
            $risoUnit = $this->normUnit($v[20] ?? null);
            $risoResult = $this->normResult($v[21] ?? null);
            $risoVoltage = $this->normVoltage($v[22] ?? null);

            // Sichtprüfung Ergebnis laut Header wäre später – bei vielen ST725-Exports kommt das Feld leer.
            // Wir lesen hier index 23 (wie in deinem bisherigen Mapping). Wenn leer: null.
            $visualResult = $this->normResult($v[23] ?? null);

            $rows[] = [
                'storage_number'  => $this->nullIfEmpty($v[0] ?? null),
                'description'     => $this->nullIfEmpty($v[1] ?? null),
                'inspection_date' => $this->parseDate($v[2] ?? null),
                'result'          => $this->normResult($v[3] ?? null),

                // Klassifizierung
                'class' => $class,

                // RPE
                'rpe'          => $rpeValue,
                'rpe_operator' => $rpeOp,
                'rpe_unit'     => $rpeUnit,
                'rpe_result'   => $rpeResult,

                // IEA
                'iea'          => $ieaValue,
                'iea_operator' => $ieaOp,
                'iea_unit'     => $ieaUnit,
                'iea_result'   => $ieaResult,

                // RISO
                'riso'          => $risoValue,
                'riso_operator' => $risoOp,
                'riso_unit'     => $risoUnit,
                'riso_result'   => $risoResult,
                'riso_voltage'  => $risoVoltage,

                // Sichtprüfung (falls vorhanden)
                'visual_result' => $visualResult,
            ];
        }

        return $rows;
    }

    private function parseSplitNumber(?string $whole, ?string $frac): array
    {
        $whole = $this->nullIfEmpty($whole);
        $frac  = $this->nullIfEmpty($frac);

        if ($whole === null && $frac === null) {
            return [null, null];
        }

        $operator = null;
        $w = $whole ?? '0';

        // Operator kann im Ganzteil stecken, z.B. "<0" oder ">19"
        if (preg_match('/^\s*([<>])\s*(.*)\s*$/u', $w, $m)) {
            $operator = $m[1];
            $w = $m[2];
        }

        // Manche Exporte geben "0" / "08" -> 0.08
        $w = trim($w);
        $f = trim((string)($frac ?? '00'));

        // Falls frac leer oder nicht numerisch -> 00
        if ($f === '' || !preg_match('/^\d+$/', $f)) {
            $f = '00';
        }

        // number als String mit Punkt (für float/DB)
        $num = $w . '.' . str_pad($f, 2, '0', STR_PAD_RIGHT);

        // validieren
        if (!is_numeric($num)) {
            return [null, $operator];
        }

        return [$num, $operator];
    }

    private function parseDate(?string $date): ?string
    {
        $date = $this->nullIfEmpty($date);
        if ($date === null) {
            return null;
        }

        // ST725: dd/mm/yyyy
        $p = explode('/', $date);
        if (count($p) === 3) {
            [$d, $m, $y] = $p;
            if (strlen($y) === 4) {
                return sprintf('%04d-%02d-%02d', (int)$y, (int)$m, (int)$d);
            }
        }

        return null;
    }

    private function normUnit(?string $unit): ?string
    {
        $unit = $this->nullIfEmpty($unit);
        if ($unit === null) return null;

        $u = trim($unit);

        // ST725 schreibt oft "MOhm"
        $u = str_replace(['MOhm', 'Ohm'], ['MΩ', 'Ω'], $u);
        $u = str_replace(['MO', 'MΩ'], ['MΩ', 'MΩ'], $u);

        return $u;
    }

    private function normVoltage(?string $v): ?string
    {
        $v = $this->nullIfEmpty($v);
        if ($v === null) return null;

        return trim($v); // z.B. "500V"
    }

    private function normResult(?string $value): ?string
    {
        $value = $this->nullIfEmpty($value);
        if ($value === null) return null;

        $v = mb_strtolower(trim($value));

        // vereinheitlichen
        if ($v === 'i.o.' || $v === 'ok' || $v === 'passed') return 'Bestanden';
        if ($v === 'fail' || $v === 'failed') return 'nicht Bestanden';

        return $v; // "bestanden" / "nicht bestanden"
    }

    private function nullIfEmpty(?string $v): ?string
    {
        if ($v === null) return null;
        $t = trim($v);
        return $t === '' ? null : $t;
    }
}