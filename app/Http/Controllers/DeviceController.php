<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Models\Customer;
use App\Models\Device;
use App\Services\InventoryNumberGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DeviceController extends Controller
{
    public function index(): View
    {
        $devices = Device::query()
            ->with('customer')
            ->orderBy('inventory_number')
            ->paginate(20);

        return view('devices.index', compact('devices'));
    }

    public function create(Customer $customer): View
    {
        return view('devices.create', compact('customer'));
    }

    public function store(DeviceRequest $request, Customer $customer, InventoryNumberGenerator $generator): RedirectResponse
    {
        $data = $request->validated();
        $data['customer_id'] = $customer->id;

        if (empty($data['inventory_number'])) {
            $data['inventory_number'] = $generator->generate();
        }

        $device = Device::create($data);

        return redirect()
            ->route('devices.show', $device)
            ->with('status', 'Gerät wurde angelegt.');
    }

    public function show(Device $device): View
    {
        $device->load(['customer', 'inspections.measurements']);

        return view('devices.show', compact('device'));
    }

    public function edit(Device $device): View
    {
        $device->load('customer');

        return view('devices.edit', compact('device'));
    }

    public function update(DeviceRequest $request, Device $device): RedirectResponse
    {
        $device->update($request->validated());

        return redirect()
            ->route('devices.show', $device)
            ->with('status', 'Gerät wurde aktualisiert.');
    }

    public function destroy(Device $device): RedirectResponse
    {
        $customer = $device->customer;
        $device->delete();

        return redirect()
            ->route('customers.show', $customer)
            ->with('status', 'Gerät wurde gelöscht.');
    }
}
