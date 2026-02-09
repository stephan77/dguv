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
    public function create(Device $device): View
    {
        return view('inspections.create', compact('device'));
    }

    public function store(InspectionRequest $request, Device $device): RedirectResponse
    {
        $inspection = $device->inspections()->create($request->validated());

        $device->update([
            'next_inspection' => Carbon::parse($inspection->inspection_date)->addMonthsNoOverflow(12),
        ]);

        return redirect()
            ->route('devices.show', $device)
            ->with('status', 'Prüfung wurde angelegt.');
    }

    public function destroy(Inspection $inspection): RedirectResponse
    {
        $device = $inspection->device;
        $inspection->delete();

        return redirect()
            ->route('devices.show', $device)
            ->with('status', 'Prüfung wurde gelöscht.');
    }
    public function edit(Inspection $inspection)
    {
        return view('inspections.edit', compact('inspection'));
    }
public function update(Request $request, Inspection $inspection)
{
    $inspection->update([
        'inspection_date' => $request->inspection_date ?? $inspection->inspection_date,
        'inspector' => $request->inspector ?? $inspection->inspector,
        'notes' => $request->notes,
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
