# 02 – Repo-Struktur

## Wichtigste Ordner (max. 2 Ebenen)
```text
app/
  Exports/
  Http/
  Models/
  Services/
bootstrap/
config/
database/
  migrations/
  seeders/
public/
resources/
  css/
  js/
  views/
routes/
storage/
tests/
DOC/intern/
```

## Ordnerzwecke + wichtige Dateien
- `app/Http/Controllers/`: Business-Use-Cases und CRUD-Endpunkte.
  - `DeviceController.php`: Geräteverwaltung + Exporte + öffentliche Geräteseite.
  - `InspectionController.php`: Prüfungen erstellen/ändern/löschen.
  - `ImportController.php`: CSV-Import ST725.
  - `ReportController.php`: PDF-Erzeugung.
- `app/Http/Requests/`: Validierungsregeln (z. B. `InspectionRequest.php`).
- `app/Models/`: Datenmodell und Relationen (`Customer`, `Device`, `Inspection`, `Measurement`, `TestDevice`).
- `app/Services/`: technische Services (`St725CsvParser`, `InventoryNumberGenerator`).
- `database/migrations/`: vollständiges Schema inkl. `settings`, `test_devices`, professioneller Prüf-Felder.
- `resources/views/`: UI und PDF-Templates (`pdf/customer-report.blade.php`).
- `routes/web.php`: zentrale Feature-Routen.
- `routes/auth.php`: Login/Logout/Registration.
- `config/`: Laufzeitkonfiguration (DB, Logging, Queue, Mail, Filesystem, Auth).
- `tests/`: nur Laravel-Beispieltests vorhanden (keine fachlichen Tests).

## Entry Points und zentrale Konfigurationen
- `public/index.php`: Web Entry Point.
- `bootstrap/app.php`: App-Konfiguration + Routing-Registrierung.
- `composer.json`: Abhängigkeiten und Workflows (`setup`, `dev`, `test`).
- `package.json`: Frontend-Build-Skripte (`dev`, `build`).
