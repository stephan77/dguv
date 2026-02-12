<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\InspectionRequest;
use App\Models\Device;
use App\Models\Inspection;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\TestDevice;

class InspectionController extends Controller
{
    /**
     * Zeigt das Formular zum Anlegen einer neuen Prüfung
     * für ein bestimmtes Gerät.
     * Gerät kommt aus der URL: /devices/{device}/inspections/create
     */
    public function create(Device $device): View
    {
        return view('inspections.create', compact('device'));
    }

    /**
     * Speichert eine neue Prüfung.
     * - Validierung läuft über InspectionRequest
     * - Prüfung wird direkt mit dem Gerät verknüpft
     * - Nächste Prüfung wird automatisch auf +12 Monate gesetzt
     */
public function store(InspectionRequest $request, Device $device): RedirectResponse
{
    $inspection = $device->inspections()->create($request->validated());

    $months = $inspection->interval_months ?? 12;

    $device->update([
        'next_inspection' => Carbon::parse($inspection->inspection_date)
            ->addMonthsNoOverflow($months),
    ]);

    return redirect()
        ->route('devices.show', $device)
        ->with('status', 'Prüfung wurde angelegt.');
}

    /**
     * Löscht eine Prüfung.
     * Danach Rücksprung auf die Geräteseite.
     */
    public function destroy(Inspection $inspection): RedirectResponse
    {
        $device = $inspection->device;

        $inspection->delete();

        return redirect()
            ->route('devices.show', $device)
            ->with('status', 'Prüfung wurde gelöscht.');
    }

    /**
     * Öffnet den Editor für eine bestehende Prüfung.
     */


public function edit(Inspection $inspection)
{
    $testDevices = TestDevice::orderBy('name')->get();

    return view('inspections.edit', compact('inspection', 'testDevices'));
}

    /**
     * Aktualisiert eine bestehende Prüfung UND deren Messwerte.
     *
     * Wichtig:
     * - inspection_date und inspector werden nur überschrieben,
     *   wenn Werte im Formular vorhanden sind
     * - Messwerte werden aus der ersten verknüpften Measurement-Zeile geladen
     */
public function update(Request $request, Inspection $inspection)
{
    $standard = $request->has('is_welder')
    ? 'DIN EN 60974-4'
    : 'DIN VDE 0701-0702';
    $inspection->update([
    'inspection_date' => $request->inspection_date,
    'inspector' => $request->inspector,
    'passed' => $request->passed,
    'notes' => $request->notes,
    'standard' => $standard,
    'test_device_id' => $request->test_device_id,
    'test_reason' => $request->test_reason,
    'protection_class' => $request->protection_class,
    'tester_device' => $request->tester_device,
    'tester_serial' => $request->tester_serial,
    'tester_calibrated_at' => $request->tester_calibrated_at,
    'interval_months' => $request->interval_months,
]);

    // NÄCHSTE PRÜFUNG NEU BERECHNEN
    $months = $inspection->interval_months ?? 12;

    $inspection->device->update([
        'next_inspection' => Carbon::parse($inspection->inspection_date)
            ->addMonthsNoOverflow($months),
    ]);

    $measurement = $inspection->measurements()->first();

    if ($measurement) {
        $measurement->update([
            'rpe' => $request->rpe,
            'rpe_result' => $request->rpe_result,
            'riso' => $request->riso,
            'riso_result' => $request->riso_result,
            'leakage' => $request->leakage,
            'leakage_result' => $request->leakage_result,
        ]);
    }

    return redirect()
        ->route('devices.show', $inspection->device)
        ->with('status', 'Prüfung aktualisiert');
}

}