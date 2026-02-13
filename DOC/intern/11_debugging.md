# 11 – Debugging

## Wo Logs liegen
- Dateilogs: `storage/logs/laravel.log`
- Dev-Live-Logs: `php artisan pail` (im `composer run dev` Workflow)

## Log-Format / Correlation
- Standard Laravel/Monolog-Logging.
- Korrelations-ID-Konzept im Code nicht gefunden -> `UNBEKANNT / FEHLT`.

## Häufige Fehlerbilder + Fix
- **HTTP 500 nach frischem Checkout:** `.env` fehlt / APP_KEY fehlt -> `.env` anlegen + `php artisan key:generate`.
- **DB-Fehler beim Start:** SQLite-Datei fehlt oder falsche DB-Creds -> `database/database.sqlite` anlegen oder `.env` korrigieren.
- **Views/Assets alt:** `npm run dev` bzw. `npm run build` erneut ausführen.
- **Import liefert keine Daten:** CSV-Format passt nicht zum ST725-Parser (Semikolon, erwartete Spalten).

## Debug-Start
```bash
APP_DEBUG=true php artisan serve
php artisan pail
```

## Performance-Hinweise
- Listing-Seiten nutzen Pagination (`paginate(20)`).
- Mehrere Controller verwenden Eager Loading (`with(...)`) gegen N+1.
- Kein dediziertes Profiling/Tracing-Setup gefunden -> `UNBEKANNT / FEHLT`.

## Medienfeature – typische Fehler
- **Upload schlägt mit 422 fehl:** Datei nicht in erlaubtem Format oder >50MB.
- **Medien werden im UI nicht angezeigt:** `php artisan storage:link` fehlt oder Storage-Dateirechte sind falsch.
- **Kein Thumbnail sichtbar:** GD-Funktionen (z. B. `imagewebp`) in PHP fehlen; Originalbild wird dennoch gespeichert.
- **Hauptbild-Icon fehlt trotz Medien:** Es existiert nur Video oder kein `is_primary=true` Bild.
