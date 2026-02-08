<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ImportConfirmRequest;
use App\Http\Requests\ImportUploadRequest;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Inspection;
use App\Models\Measurement;
use App\Services\St725CsvParser;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ImportController extends Controller
{
    public function create(Customer $customer): View
    {
        $devices = $customer->devices()->orderBy('name')->get();

        return view('imports.create', compact('customer', 'devices'));
    }

    public function preview(ImportUploadRequest $request, Customer $customer, St725CsvParser $parser): View
    {
        $content = $request->file('csv_file')->get();
        $rows = $parser->parse($content);

        session([
            'import_rows' => $rows,
        ]);

        $devices = $customer->devices()->orderBy('name')->get();

        return view('imports.preview', compact('customer', 'devices', 'rows'));
    }

    public function store(ImportConfirmRequest $request, Customer $customer): RedirectResponse
    {
        $rows = session('import_rows', []);

        foreach ($rows as $index => $row) {
            $deviceId = $request->input("device_ids.$index");

            if (!$deviceId) {
                continue;
            }

            $device = Device::query()
                ->where('customer_id', $customer->id)
                ->findOrFail($deviceId);

            $inspectionDate = $row['inspection_date'] ?? now()->toDateString();

            $inspection = Inspection::create([
                'device_id' => $device->id,
                'inspection_date' => $inspectionDate,
                'inspector' => auth()->user()->name . ' (' . auth()->user()->title . ')',
                'standard' => 'DGUV V3',
                'passed' => $this->isPassed($row['result'] ?? null),
                'notes' => 'Import ST725',
            ]);

Measurement::create([
    'inspection_id' => $inspection->id,
    'test_type' => 'ST725 Import',

    'rpe' => $row['rpe'] ?? null,
    'rpe_result' => $row['rpe_result'] ?? null,

    'riso' => $row['riso'] ?? null,
    'riso_result' => $row['riso_result'] ?? null,

    'leakage' => $row['iea'] ?? null,
    'leakage_result' => $row['iea_result'] ?? null,

    'passed' => $this->isPassed($row['result'] ?? null),

    'raw_data' => [
        'storage_number' => $row['storage_number'] ?? null,
        'description' => $row['description'] ?? null,
        'inspection_date' => $row['inspection_date'] ?? null,
        'result' => $row['result'] ?? null,

        'rpe' => $row['rpe'] ?? null,
        'rpe_unit' => $row['rpe_unit'] ?? 'Ohm',
        'rpe_result' => $row['rpe_result'] ?? null,

        'riso' => $row['riso'] ?? null,
        'riso_unit' => $row['riso_unit'] ?? 'MΩ',
        'riso_result' => $row['riso_result'] ?? null,

        'iea' => $row['iea'] ?? null,
        'iea_unit' => $row['iea_unit'] ?? 'mA',
        'iea_result' => $row['iea_result'] ?? null,

        // AUTO-FÜLLEN WENN CSV KEINE ANGABE HAT
        'visual_result' => $row['visual_result']
            ?? ($this->isPassed($row['result'] ?? null) ? 'bestanden' : 'nicht bestanden'),

        'function_result' => $row['function_result']
            ?? ($this->isPassed($row['result'] ?? null) ? 'bestanden' : 'nicht bestanden'),
    ],
]);

            $device->update([
                'next_inspection' => Carbon::parse($inspectionDate)
                    ->addMonthsNoOverflow(12),
            ]);
        }

        session()->forget('import_rows');

        return redirect()
            ->route('customers.show', $customer)
            ->with('status', 'Import abgeschlossen.');
    }

    private function isPassed(?string $value): bool
    {
        if (!$value) {
            return false;
        }

        $normalized = strtolower(trim($value));

        return in_array($normalized, ['ok', 'passed', 'bestanden', 'i.o.'], true);
    }
}