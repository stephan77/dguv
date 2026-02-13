# 08 – API-Integrationen

## Externe Systeme (im Code nachweisbar)

### 1) ST725 CSV Import (Datei-basierte Integration)
- Zweck: Messwerte aus Benning ST725-Export übernehmen.
- Auth: keine (lokaler Datei-Upload).
- Endpunkt intern: `POST /customers/{customer}/import/preview`, `POST /customers/{customer}/import`.
- Parser: `app/Services/St725CsvParser.php`.
- Timeout/Retry: keine explizite Import-Retry-Logik gefunden.
- Konfiguration: keine dedizierten ENV-Variablen.
- Local Dev Mocking: mit Beispiel-CSV manuell testbar.

### 2) PDF-Generierung (dompdf)
- Zweck: Kundenbericht als PDF.
- Auth: über App-Session (Route in auth middleware).
- Endpunkt intern: `GET /customers/{customer}/report`.
- Template: `resources/views/pdf/customer-report.blade.php`.
- Konfiguration: package-default; keine projektspezifischen ENV im Repo.

### 3) Excel-Export (maatwebsite/excel)
- Zweck: Geräte- und QR-Exports.
- Auth: über App-Session (Export-Routen in auth middleware).
- Endpunkte intern:
  - `/devices/export`
  - `/customers/{customer}/export`
  - `/devices/export-qr`
  - `/customers/{customer}/export-qr`
- Exports: `app/Exports/*`.

## Nicht nachweisbar / fehlt
- Externe REST-APIs, Queue-Broker außerhalb Laravel DB-Queue, Cloud Storage-Verbindungen, Webhooks: im Projektcode nicht aktiv genutzt bzw. nicht dokumentiert -> `UNBEKANNT / FEHLT`.

## Neue interne Media-Endpoints
Alle Endpunkte liegen im `auth`-Middleware-Kontext und nutzen die bestehende Session-Authentifizierung.

- `GET /devices/{device}/media`
  - Liefert Medienliste des Geräts (inkl. URL/Thumbnail-URL).
- `POST /devices/{device}/media`
  - Multipart-Upload (`files[]`) für Mehrfachupload.
  - Validierung: erlaubte MIME-Typen + max. Dateigröße.
- `PATCH /devices/{device}/media/{media}/primary`
  - Setzt ein Bild als Hauptbild.
- `DELETE /devices/{device}/media/{media}`
  - Löscht Metadatensatz und zugehörige Datei(en) im Storage.
