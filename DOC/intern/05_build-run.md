# 05 – Build & Run

## Lokale Build-Pipeline
```bash
composer install
npm install
npm run build
```

## Startmodi
- **Dev (alles parallel):**
  ```bash
  composer run dev
  ```
- **Nur Backend:**
  ```bash
  php artisan serve
  ```
- **Nur Queue Worker:**
  ```bash
  php artisan queue:listen --tries=1 --timeout=0
  ```
- **Nur Frontend-Dev-Server:**
  ```bash
  npm run dev
  ```
- **Tests:**
  ```bash
  composer test
  ```

## Wichtige Composer-Skripte
- `setup`: installiert Dependencies, erstellt `.env`, key:generate, migrate, npm install, npm build.
- `dev`: startet Server + Queue + Pail + Vite.
- `test`: `php artisan config:clear` + `php artisan test`.

## Migrationen / Seed-Daten
- Migrationen liegen in `database/migrations/`.
- Standard-Seed: `database/seeders/DatabaseSeeder.php` erzeugt einen Test-User.

```bash
php artisan migrate
php artisan db:seed
```

## Produktionsstart
Eindeutiger produktiver Startbefehl/Process-Manager (Supervisor/systemd/Container) ist im Repo nicht definiert -> `UNBEKANNT / FEHLT`.
