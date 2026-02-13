<?php

declare(strict_types=1);

// Controller werden eingebunden, damit die Routen auf deren Methoden zeigen können
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceMediaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Startseite "/" leitet IMMER auf das Dashboard weiter
Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/public/device/{device}', [DeviceController::class, 'public'])
    ->name('devices.public');

// Alle Routen in dieser Gruppe sind nur erreichbar, wenn ein User eingeloggt ist
Route::middleware('auth')->group(function () {

    // Dashboard Seite
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Seiten im Dashboard (vermutlich statische Views oder Übersichten)
    Route::get('/import', [DashboardController::class, 'imports'])
        ->name('imports.index');

    Route::get('/reports', [DashboardController::class, 'reports'])
        ->name('reports.index');

    // Standard CRUD-Routen für Kunden:
    // index, create, store, show, edit, update, destroy 
    Route::resource('customers', CustomerController::class);

    // Gerät bei einem bestimmten Kunden anlegen (Custom Route)
    Route::get('/customers/{customer}/devices/create', [DeviceController::class, 'create'])
        ->name('customers.devices.create');

    Route::post('/customers/{customer}/devices', [DeviceController::class, 'store'])
        ->name('customers.devices.store');

    // CSV-Import für Geräte/Prüfdaten eines Kunden
    Route::get('/customers/{customer}/import', [ImportController::class, 'create'])
        ->name('customers.import.create');

    Route::post('/customers/{customer}/import/preview', [ImportController::class, 'preview'])
        ->name('customers.import.preview');

    Route::post('/customers/{customer}/import', [ImportController::class, 'store'])
        ->name('customers.import.store');

    // Kundenbericht (PDF o.ä.)
    Route::get('/customers/{customer}/report', [ReportController::class, 'customer'])
        ->name('customers.report');

    // Standard CRUD für Geräte
    // create/store sind ausgeschlossen, weil Geräte IMMER über einen Kunden erstellt werden
    Route::resource('devices', DeviceController::class)->except(['create', 'store']);


    Route::get('/devices/{device}/media', [DeviceMediaController::class, 'index'])
        ->name('devices.media.index');

    Route::post('/devices/{device}/media', [DeviceMediaController::class, 'store'])
        ->name('devices.media.store');

    Route::patch('/devices/{device}/media/{media}/primary', [DeviceMediaController::class, 'setPrimary'])
        ->name('devices.media.primary');

    Route::delete('/devices/{device}/media/{media}', [DeviceMediaController::class, 'destroy'])
        ->name('devices.media.destroy');

    // Etikett/Label für ein Gerät
    Route::get('/devices/{device}/label', [LabelController::class, 'show'])
        ->name('devices.label');

    // Neue Prüfung für ein Gerät anlegen
    Route::get('/devices/{device}/inspections/create', [InspectionController::class, 'create'])
        ->name('devices.inspections.create');

    Route::post('/devices/{device}/inspections', [InspectionController::class, 'store'])
        ->name('devices.inspections.store');

    // Prüfung löschen
    Route::delete('/inspections/{inspection}', [InspectionController::class, 'destroy'])
        ->name('inspections.destroy');

    // User-Verwaltung (ohne Detailansicht)
    Route::resource('users', UserController::class)->except(['show']);

    // Registrierung an/aus schalten
    Route::post('/users/toggle-registration', [UserController::class, 'toggleRegistration'])
        ->name('users.toggleRegistration');

    // Excel Export aller Geräte
    Route::get('/devices/export', [DeviceController::class, 'exportAll'])
        ->name('devices.export');

    // Excel Export aller Geräte eines Kunden
    Route::get('/customers/{customer}/export', [DeviceController::class, 'exportCustomer'])
        ->name('customers.devices.export');

    // Prüfung bearbeiten
    Route::get('/inspections/{inspection}/edit', [InspectionController::class, 'edit'])
        ->name('inspections.edit');
    //QR CODE Kunde
    Route::get('/devices/export-qr', [DeviceController::class, 'exportQr'])
    ->name('devices.export.qr');
Route::get('/customers/{customer}/export-qr',
    [DeviceController::class, 'exportCustomerQr']
)->name('customers.devices.exportQr');
    // Prüfung speichern (Update)
    Route::put('/inspections/{inspection}', [InspectionController::class, 'update'])
        ->name('inspections.update');
    Route::resource('test-devices', \App\Http\Controllers\TestDeviceController::class)->except(['show']);    
});

// Laravel Standard Auth-Routen (Login, Logout, Passwort, etc.)
require __DIR__ . '/auth.php';