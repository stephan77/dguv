# 07 – Datenbank

## DB-Typ + Version
- Lokal default: SQLite (`DB_CONNECTION=sqlite`).
- Weitere Treiber sind Laravel-standardmäßig konfigurierbar (MySQL/PostgreSQL/SQL Server).
- Konkrete produktive DB-Version im Repo nicht dokumentiert -> `UNBEKANNT / FEHLT`.

## Schema-Überblick
Kern-Tabellen:
- `customers`
- `devices` (FK `customer_id`)
- `inspections` (FK `device_id`, später `test_device_id`)
- `measurements` (FK `inspection_id`, `raw_data` JSON)
- `test_devices`
- `settings`
- Laravel-Standardtabellen: `users`, `sessions`, `cache`, `jobs`, usw.

## Beziehungen
- Customer 1:n Device
- Device 1:n Inspection
- Inspection 1:n Measurement
- Inspection n:1 TestDevice (optional)

## Migrationen
- Tool: Laravel Migrations (`php artisan migrate`)
- Pfad: `database/migrations/`

Ablauf:
```bash
php artisan migrate
# Reset lokal:
php artisan migrate:fresh --seed
```

## Wichtige Entities
- `Device.next_inspection` wird bei Prüfungsanlage/-update automatisch neu berechnet.
- `Measurement.raw_data` speichert importierte ST725-Rohdaten.
- `settings` enthält Feature-Flags wie `registration_enabled`.

## Seed/Testdaten
- `DatabaseSeeder` erstellt genau einen Beispiel-User (`test@example.com`).
- Weitere fachliche Seeds fehlen.

## Backup/Restore
- Kein Backup-/Restore-Prozess im Repo dokumentiert -> `UNBEKANNT / FEHLT`.

## Neue Entität: `device_media`
Felder:
- `id`
- `device_id` (FK -> `devices.id`, cascadeOnDelete)
- `file_path`
- `thumbnail_path` (nullable)
- `file_type` (`image|video`)
- `is_primary` (bool)
- `uploaded_by` (FK -> `users.id`, nullable, nullOnDelete)
- `uploaded_at`
- `created_at` / `updated_at`

Relationen:
- Device `1:n` DeviceMedia (`Device::media()`)
- Device `1:1` primäres Bild (`Device::primaryMedia()` via `is_primary=true`)
