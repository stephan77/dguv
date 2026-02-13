<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Models\Customer;
use App\Models\Device;
use App\Services\InventoryNumberGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Exports\DevicesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DeviceQrExport;
use App\Exports\CustomerQrExport;

class DeviceController extends Controller
{
    /**
     * LISTE ALLER GERÄTE
     *
     * Zeigt eine paginierte Übersicht aller Geräte im System.
     * - Lädt direkt den zugehörigen Kunden mit (Relation: customer)
     * - Sortiert nach Inventarnummer
     * - 20 Einträge pro Seite
     *
     * Route: GET /devices
     */
    public function index(): View
    {
        $devices = Device::query()
            ->with('customer')              // Verhindert zusätzliche DB-Abfragen pro Zeile
            ->orderBy('inventory_number')   // Saubere Sortierung
            ->paginate(20);                 // Pagination

        return view('devices.index', compact('devices'));
    }

    /**
     * FORMULAR: NEUES GERÄT ANLEGEN
     *
     * Wird aus der Kundenansicht aufgerufen:
     * /customers/{customer}/devices/create
     *
     * Übergibt den Kunden an die View, damit das Gerät direkt
     * diesem Kunden zugeordnet werden kann.
     */
    public function create(Customer $customer): View
    {
        return view('devices.create', compact('customer'));
    }

    /**
     * SPEICHERT EIN NEUES GERÄT
     *
     * - Validierung über DeviceRequest
     * - Verknüpft Gerät mit dem Kunden
     * - Generiert automatisch eine Inventarnummer, falls leer
     *
     * Route: POST /customers/{customer}/devices
     */
    public function store(DeviceRequest $request, Customer $customer, InventoryNumberGenerator $generator): RedirectResponse
    {
        $data = $request->validated();

        // Verknüpfung zum Kunden
        $data['customer_id'] = $customer->id;

        // Inventarnummer automatisch erzeugen, falls nicht gesetzt
        if (empty($data['inventory_number'])) {
            $data['inventory_number'] = $generator->generate();
        }

        $device = Device::create($data);

        return redirect()
            ->route('devices.show', $device)
            ->with('status', 'Gerät wurde angelegt.');
    }

    /**
     * DETAILSEITE EINES GERÄTS
     *
     * Lädt:
     * - Kunde
     * - Alle Prüfungen
     * - Messwerte jeder Prüfung
     *
     * Route: GET /devices/{device}
     */
    public function show(Device $device): View
    {
        $device->load([
            'customer',
            'inspections.measurements', // verschachtelte Relation
            'media',
            'primaryMedia',
        ]);

        return view('devices.show', compact('device'));
    }

    /**
     * FORMULAR: GERÄT BEARBEITEN
     *
     * Route: GET /devices/{device}/edit
     */
    public function edit(Device $device): View
    {
        $device->load('customer');

        return view('devices.edit', compact('device'));
    }

    /**
     * GERÄTEDATEN AKTUALISIEREN
     *
     * Route: PUT/PATCH /devices/{device}
     */
    public function update(DeviceRequest $request, Device $device): RedirectResponse
    {
        $device->update($request->validated());

        return redirect()
            ->route('devices.show', $device)
            ->with('status', 'Gerät wurde aktualisiert.');
    }

    /**
     * GERÄT LÖSCHEN
     *
     * - Gerät wird entfernt
     * - Danach Rücksprung zur Kundenseite
     *
     * Route: DELETE /devices/{device}
     */
    public function destroy(Device $device): RedirectResponse
    {
        $customer = $device->customer;

        $device->delete();

        return redirect()
            ->route('customers.show', $customer)
            ->with('status', 'Gerät wurde gelöscht.');
    }

    /**
     * EXCEL EXPORT – ALLE GERÄTE
     *
     * Route: GET /devices/export
     *
     * Erstellt eine Excel-Datei mit:
     * - allen Geräten
     * - inkl. Kundenbeziehung
     */
    public function exportAll()
    {
        return Excel::download(
            new DevicesExport(
                Device::with('customer')->get()
            ),
            'alle-geraete.xlsx'
        );
    }

    /**
     * EXCEL EXPORT – NUR EIN KUNDE
     *
     * Route: GET /customers/{customer}/export
     *
     * Exportiert ausschließlich die Geräte
     * eines bestimmten Kunden.
     */
    public function exportCustomer(Customer $customer)
    {
        return Excel::download(
            new DevicesExport($customer->devices),
            'geraete-'.$customer->company.'.xlsx'
        );
    }
    public function public(Device $device): View
    {
        $device->load(['customer', 'inspections.measurements']);

        return view('devices.public', compact('device'));
    }
    public function exportQr()
{
    return Excel::download(
        new DeviceQrExport(Device::all()),
        'qr-labels.xlsx'
    );
}
public function exportCustomerQr(Customer $customer)
{
    return Excel::download(
        new CustomerQrExport($customer->devices),
        'qr-'.$customer->company.'.xlsx'
    );
}
}