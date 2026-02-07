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

            $device = Device::query()->where('customer_id', $customer->id)->findOrFail($deviceId);

            $inspection = Inspection::create([
                'device_id' => $device->id,
                'inspection_date' => $row['inspection_date'] ?? now()->toDateString(),
                'inspector' => $row['inspector'] ?? 'Import',
                'standard' => 'DGUV V3',
                'passed' => $this->isPassed($row['result'] ?? null),
                'notes' => 'Import ST725',
            ]);

            Measurement::create([
                'inspection_id' => $inspection->id,
                'test_type' => 'ST725 Import',
                'rpe' => $row['rpe'],
                'rpe_result' => $row['rpe_result'],
                'riso' => $row['riso'],
                'riso_result' => $row['riso_result'],
                'leakage' => $row['leakage'],
                'leakage_result' => $row['leakage_result'],
                'passed' => $this->isPassed($row['result'] ?? null),
            ]);

            $device->update([
                'next_inspection' => Carbon::parse($inspection->inspection_date)->addMonthsNoOverflow(12),
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
