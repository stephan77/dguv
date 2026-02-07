<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard');
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
