<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\View\View;
use App\Models\Device;
use App\Models\Inspection;

class DashboardController extends Controller
{
public function index()
{
    $totalCustomers = Customer::count();
    $totalDevices   = Device::count();

    $dueInspections = Device::whereDate('next_inspection', '<=', now()->addDays(7))->count();

    $failedDevices = Inspection::where('passed', false)->count();

    $customers = Customer::withCount('devices')
        ->latest()
        ->take(5)
        ->get();

    $devices = Device::with('customer')
        ->latest()
        ->take(5)
        ->get();

    $inspections = Inspection::with('device')
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'totalCustomers',
        'totalDevices',
        'dueInspections',
        'failedDevices',
        'customers',
        'devices',
        'inspections'
    ));
}

    public function imports(): View
    {
        $customers = Customer::query()->orderBy('company')->get();

        return view('imports.index', compact('customers'));
    }

    public function reports(): View
    {
        $customers = Customer::query()->orderBy('company')->get();

        return view('reports.index', compact('customers'));
    }
}
