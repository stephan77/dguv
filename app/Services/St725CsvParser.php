<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;

class St725CsvParser
{
    /**
     * @return array<int, array<string, string|null>>
     */
    public function parse(string $content): array
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($content));
        if (!$lines) {
            return [];
        }

        $delimiter = $this->guessDelimiter($lines[0]);
        $rows = [];

        foreach ($lines as $line) {
            if ($line === '') {
                continue;
            }

            $cells = str_getcsv($line, $delimiter);
            if (!$cells) {
                continue;
            }

            $rows[] = [
                'storage_number' => $cells[0] ?? null,
                'description' => $cells[1] ?? null,
                'result' => $cells[2] ?? null,
                'inspection_date' => $this->normalizeDate($cells[3] ?? null),
                'rpe' => $cells[4] ?? null,
                'rpe_result' => $cells[5] ?? null,
                'riso' => $cells[6] ?? null,
                'riso_result' => $cells[7] ?? null,
                'leakage' => $cells[8] ?? null,
                'leakage_result' => $cells[9] ?? null,
                'inspector' => $cells[10] ?? null,
            ];
        }

        return $rows;
    }

    private function guessDelimiter(string $line): string
    {
        return substr_count($line, ';') > substr_count($line, ',') ? ';' : ',';
    }

    private function normalizeDate(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $value = trim($value);

        foreach (['d.m.Y', 'd/m/Y', 'Y-m-d'] as $format) {
            $date = Carbon::createFromFormat($format, $value);
            if ($date !== false) {
                return $date->format('Y-m-d');
            }
        }

        return null;
    }
}
