# 00 – Quickstart

## TL;DR (2 Minuten)

### Was ist das System?
Webanwendung zur Verwaltung und Dokumentation von DGUV-Prüfungen (Kunden, Geräte, Prüfungen, Messwerte, Exporte, PDF-Berichte).

### Tech-Stack
- Backend: PHP 8.2 + Laravel 12
- Frontend-Build: Vite + TailwindCSS
- DB: standardmäßig SQLite (lokal), MySQL/PostgreSQL/SQL Server via Laravel-Konfig möglich
- Exporte: maatwebsite/excel (XLSX)
- PDF: barryvdh/laravel-dompdf
- QR: simplesoftwareio/simple-qrcode

### Entry Points
- HTTP-Einstieg: `public/index.php`
- Laravel Bootstrap: `bootstrap/app.php`
- Hauptrouten: `routes/web.php`, `routes/auth.php`

### Schnellstart-Kommandos (Copy/Paste)
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
composer run dev
```

### Wo konfigurieren?
- `.env` (Basis)
- `config/*.php` (z. B. `app.php`, `database.php`, `logging.php`, `queue.php`)

### Wo Logs?
- Default-Datei: `storage/logs/laravel.log`
- Live-Log im Dev-Workflow: über `php artisan pail` (Teil von `composer run dev`)

### Wie Tests ausführen?
```bash
composer test
# oder
php artisan test
```

## Erster erfolgreicher Run – Checkliste
- [ ] `php artisan migrate` läuft ohne Fehler.
- [ ] `composer run dev` startet Server/Queue/Logs/Vite parallel.
- [ ] Login unter `http://127.0.0.1:8000/login` erreichbar.
- [ ] Nach Login ist Dashboard sichtbar.
- [ ] Kunde kann angelegt werden.
- [ ] Gerät kann für Kunde angelegt werden.
- [ ] Prüfung kann angelegt werden.

## Neu: Medien für Devices & Prüfgeräte (Bilder/Videos)
- Feature: Upload, Verwaltung und Anzeige von Medien auf Device- und Prüfgeräte-Detailseiten.
- Unterstützte Formate: `jpg`, `jpeg`, `png`, `webp`, `mp4`, `webm`.
- Das gleiche Media-Backend (`MediaService` + `device_media` polymorph) versorgt beide Bereiche.
- Nach Migration sollte einmal `php artisan storage:link` geprüft werden, damit Medien-URLs (`/storage/...`) erreichbar sind.

## Mobile/Tablet Nutzung
- Anwendung ist responsive optimiert (ein Codepfad für Desktop, Tablet, Smartphone).
- Mobile Navigation erfolgt über das Menü-Button/Burger-Verhalten im Hauptlayout.
- Tabellen wechseln auf Smartphones automatisch in Kartenansichten, damit keine horizontale Scrollpflicht besteht.
- Prüf- und Stammdaten-Formulare haben mobile Touch-Abstände und größere Eingabefelder.
- PWA-Light ist aktiv: Browser können „Zum Homescreen hinzufügen“ anbieten (Manifest + Meta-Tags).
