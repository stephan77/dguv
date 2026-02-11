<?php

namespace App\Http\Controllers;

use App\Models\TestDevice;
use Illuminate\Http\Request;

class TestDeviceController extends Controller
{
    public function index()
    {
        $devices = TestDevice::orderBy('name')->get();
        return view('test_devices.index', compact('devices'));
    }

    public function create()
    {
        return view('test_devices.create');
    }

    public function store(Request $request)
    {
        TestDevice::create($request->validate([
            'name' => 'required',
            'serial_number' => 'required',
            'calibrated_until' => 'nullable|date',
        ]));

        return redirect()->route('test-devices.index');
    }

    public function edit(TestDevice $testDevice)
    {
        return view('test_devices.edit', compact('testDevice'));
    }

    public function update(Request $request, TestDevice $testDevice)
    {
        $testDevice->update($request->validate([
            'name' => 'required',
            'serial_number' => 'required',
            'calibrated_until' => 'nullable|date',
        ]));

        return redirect()->route('test-devices.index');
    }

    public function destroy(TestDevice $testDevice)
    {
        $testDevice->delete();
        return back();
    }
}