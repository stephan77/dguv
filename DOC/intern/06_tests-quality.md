# 06 – Tests & Qualität

## Testarten und Ablage
- Unit-Tests: `tests/Unit/`
- Feature-Tests: `tests/Feature/`
- Aktuell nur Beispieltests vorhanden (`ExampleTest.php`).

## Testausführung
```bash
composer test
# oder
php artisan test
```

## Coverage
- Keine Coverage-Konfiguration im Repo gefunden (z. B. kein phpunit coverage target, kein CI-Upload) -> `UNBEKANNT / FEHLT`.

## Lint / Format / Static Analysis
- `laravel/pint` ist als dev dependency vorhanden.
- Keine dedizierte Pint-Konfigdatei im Repo gefunden (Laravel-Defaults gelten).
- Keine PHPStan/Psalm-Konfiguration gefunden -> `UNBEKANNT / FEHLT`.

Beispiel:
```bash
./vendor/bin/pint
```

## Pre-commit / CI Gates
- Keine `.github/workflows/`, `.gitlab-ci.yml` oder Hooks-Konfiguration im Repo gefunden.
- Daher keine automatischen Quality Gates versioniert -> `UNBEKANNT / FEHLT`.
