# DGUV V3 / VDE Prüfmanagement

Eine Laravel 12 Anwendung für DGUV V3 / VDE Geräteprüfungen inklusive Kunden-, Geräte- und Prüfmanagement, ST725 CSV-Import sowie PDF-Ausgaben.

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

> Hinweis: Für SQLite ist die Datenbank bereits unter `database/database.sqlite` angelegt. Für MySQL bitte die `.env`-Variablen anpassen.

## Enthaltene Modelle
- `Customer`
- `Device`
- `Inspection`
- `Measurement`
- `User`

## Migrationen
- `create_users_table`
- `create_password_reset_tokens_table`
- `create_customers_table`
- `create_devices_table`
- `create_inspections_table`
- `create_measurements_table`

## Controller
- `DashboardController` (Dashboard, Import- und Report-Auswahl)
- `CustomerController` (CRUD)
- `DeviceController` (CRUD)
- `InspectionController` (Prüfungen)
- `ImportController` (ST725 CSV Import)
- `LabelController` (Inventar-Etikett als PDF)
- `ReportController` (Kunden-Komplettbericht als PDF)
- Auth: `AuthenticatedSessionController`, `RegisteredUserController`

## Views
- Layout: `resources/views/layouts/app.blade.php`
- Auth: `auth/login`, `auth/register`
- Dashboard: `dashboard`
- Kunden: `customers/index`, `customers/create`, `customers/edit`, `customers/show`
- Geräte: `devices/index`, `devices/create`, `devices/edit`, `devices/show`
- Prüfungen: `inspections/create`
- Import: `imports/index`, `imports/create`, `imports/preview`
- Berichte: `reports/index`
- PDF: `pdf/device-label`, `pdf/customer-report`

## Routes
- Auth: `routes/auth.php`
- Anwendung: `routes/web.php`

## Features
- Automatische Inventarnummer (Format `INV-000001`)
- ST725 CSV Vorschau + Import
- Prüfplakette/Next Inspection (12 Monate)
- PDF-Ausgaben für Etikett und Kundenbericht

