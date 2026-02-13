# 03 – Setup lokal

## Voraussetzungen
- PHP 8.2+
- Composer 2+
- Node.js + npm
- SQLite (oder alternative DB passend zu `.env`)

## Schritt-für-Schritt

### 1) Repository klonen
```bash
git clone <REPO_URL>
cd dguv
```

### 2) Backend-Abhängigkeiten
```bash
composer install
```

### 3) ENV einrichten
```bash
cp .env.example .env
php artisan key:generate
```

### 4) Datenbank vorbereiten
Standard ist SQLite (`DB_CONNECTION=sqlite`).
```bash
touch database/database.sqlite
php artisan migrate
```

### 5) Frontend-Abhängigkeiten
```bash
npm install
```

### 6) Anwendung starten
```bash
composer run dev
```
Startet parallel:
- `php artisan serve`
- `php artisan queue:listen --tries=1 --timeout=0`
- `php artisan pail --timeout=0`
- `npm run dev`

## Häufige Setup-Probleme
- **`APP_KEY` fehlt** -> `php artisan key:generate`.
- **SQLite-Datei fehlt** -> `touch database/database.sqlite`.
- **Migration-Fehler** -> `.env` DB-Werte prüfen, dann `php artisan migrate:fresh` (Achtung: Datenverlust).
- **Assets fehlen** -> `npm install` + `npm run dev`/`npm run build`.
