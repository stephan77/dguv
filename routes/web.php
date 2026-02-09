<?php

declare(strict_types=1);

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/import', [DashboardController::class, 'imports'])->name('imports.index');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports.index');

    Route::resource('customers', CustomerController::class);

    Route::get('/customers/{customer}/devices/create', [DeviceController::class, 'create'])->name('customers.devices.create');
    Route::post('/customers/{customer}/devices', [DeviceController::class, 'store'])->name('customers.devices.store');

    Route::get('/customers/{customer}/import', [ImportController::class, 'create'])->name('customers.import.create');
    Route::post('/customers/{customer}/import/preview', [ImportController::class, 'preview'])->name('customers.import.preview');
    Route::post('/customers/{customer}/import', [ImportController::class, 'store'])->name('customers.import.store');

    Route::get('/customers/{customer}/report', [ReportController::class, 'customer'])->name('customers.report');

    Route::resource('devices', DeviceController::class)->except(['create', 'store']);
    Route::get('/devices/{device}/label', [LabelController::class, 'show'])->name('devices.label');

    Route::get('/devices/{device}/inspections/create', [InspectionController::class, 'create'])->name('devices.inspections.create');
    Route::post('/devices/{device}/inspections', [InspectionController::class, 'store'])->name('devices.inspections.store');
    Route::delete('/inspections/{inspection}', [InspectionController::class, 'destroy'])->name('inspections.destroy');

    Route::resource('users', UserController::class)->except(['show']);
    Route::post('/users/toggle-registration', [UserController::class, 'toggleRegistration'])->name('users.toggleRegistration');

    //Route::get('/devices/export', [DeviceController::class, 'export'])->name('devices.export');
    Route::get('/devices/export', [DeviceController::class, 'exportAll'])->name('devices.export');

    Route::get('/customers/{customer}/export', [DeviceController::class, 'exportCustomer'])->name('customers.devices.export');

    Route::get('/inspections/{inspection}/edit', [InspectionController::class, 'edit'])
    ->name('inspections.edit');

    Route::put('/inspections/{inspection}', [InspectionController::class, 'update'])
    ->name('inspections.update');

});

require __DIR__ . '/auth.php';
