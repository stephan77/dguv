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
        // Neue Prüfung für dieses Gerät erstellen
        $inspection = $device->inspections()->create($request->validated());

        // Gerät bekommt automatisch ein neues nächstes Prüfdatum
        $device->update([
            'next_inspection' => Carbon::parse($inspection->inspection_date)
                ->addMonthsNoOverflow(12),
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
        return view('inspections.edit', compact('inspection'));
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
        // Prüfungsdaten aktualisieren
$inspection->update([
    'inspection_date' => $request->inspection_date ?? $inspection->inspection_date,
    'inspector' => $request->inspector ?? $inspection->inspector,
    'passed' => $request->passed,
    'notes' => $request->notes,
]);

        // Zugehörige Messwerte holen (erste Messung dieser Prüfung)
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