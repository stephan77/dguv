# 01 – Architektur

## High-Level
Monolithische Laravel-Webanwendung (Server-rendered Blade Views). Domäne basiert auf relationalen Kernobjekten:
- Customer
- Device
- Inspection
- Measurement
- TestDevice

## Komponenten und Verantwortungen
- `routes/web.php`: HTTP-Routing, zentrale Use-Cases.
- `app/Http/Controllers/*`: Orchestrierung (CRUD, Import, Export, Report, Auth, User-Admin).
- `app/Http/Requests/*`: Input-Validierung.
- `app/Models/*`: Eloquent-Modelle + Beziehungen.
- `app/Services/St725CsvParser.php`: CSV-Normalisierung ST725.
- `app/Services/InventoryNumberGenerator.php`: Inventarnummern-Generierung.
- `resources/views/*`: UI-Templates + PDF-Templates.
- `database/migrations/*`: Schema-Definition.

## Datenfluss (Hauptflow)
```mermaid
flowchart LR
    U[User] -->|HTTP| R[routes/web.php]
    R --> C[Controller]
    C --> V[FormRequest Validation]
    C --> M[Eloquent Models]
    M --> DB[(SQLite/MySQL/...)]
    C --> B[Blade Views]
    C --> P[PDF/Excel Export]
```

## Auth/Permissions-Konzept
- Fast alle Business-Routen liegen in `Route::middleware('auth')`.
- Öffentlich ist explizit `GET /public/device/{device}`.
- Registrierung ist per Setting `registration_enabled` schaltbar (`settings` Tabelle + `setting()` Helper).
- **Keine fein-granularen Rollen/Policies im Code gefunden** -> `UNBEKANNT / FEHLT`.

## Error-Handling / Retries
- Kein projektspezifischer globaler Exception-Handler konfiguriert (nur Laravel-Standard in `bootstrap/app.php`).
- Queue-Listener wird im Dev-Script mit `--tries=1 --timeout=0` gestartet.
- Zusätzliche Retry-Strategien für Integrationen: `UNBEKANNT / FEHLT`.

## Observability
- Logging via Laravel Logging-Stack (`config/logging.php`).
- `storage/logs/laravel.log` (single/daily je Konfiguration).
- Keine projekt-spezifischen Metrics/Tracing-Integrationen gefunden -> `UNBEKANNT / FEHLT`.

## Kritische Abhängigkeiten
- `laravel/framework`
- `barryvdh/laravel-dompdf` (Berichte)
- `maatwebsite/excel` (Exporte)
- `simplesoftwareio/simple-qrcode` (QR-Workflows)
- `vite` + `tailwindcss` (Frontend-Build)

## Media-Flow für Devices & Prüfgeräte
Neuer Teilfluss für polymorphe Medien:
1. UI (`devices/show.blade.php` und `test_devices/show.blade.php`) startet Upload via Drag&Drop oder Dateiauswahl.
2. Upload trifft `MediaController` (Device- und Prüfgeräte-Routen).
3. Validierung prüft MIME/Dateityp/Dateigröße.
4. `MediaService` speichert Datei im `public`-Storage, erzeugt bei Bildern ein Thumbnail und markiert automatisch das erste Bild je Entity als Hauptbild.
5. Persistenz in Tabelle `device_media` über polymorphe Felder `mediable_type` + `mediable_id`.
6. Anzeige:
   - Hauptbild-Icon in Listen (Device und Prüfgerät).
   - Gemeinsame Slideshow-Komponente (`resources/views/media/manager.blade.php`) für Detailseiten.

## Legacy-Hinweis
`device_id` bleibt aus Kompatibilitätsgründen in `device_media` erhalten (nullable), neue Logik nutzt `mediable_*`.
