# Interne Entwicklerdokumentation – DGUV Prüfmanagement

Ziel dieser Doku: Neue Entwickler sollen das Projekt in **<= 30 Minuten** verstehen, lokal starten und sicher weiterentwickeln können.

## Kapitel
1. [00_quickstart.md](./00_quickstart.md)
2. [01_architektur.md](./01_architektur.md)
3. [02_repo-struktur.md](./02_repo-struktur.md)
4. [03_setup-local.md](./03_setup-local.md)
5. [04_konfiguration-env.md](./04_konfiguration-env.md)
6. [05_build-run.md](./05_build-run.md)
7. [06_tests-quality.md](./06_tests-quality.md)
8. [07_datenbank.md](./07_datenbank.md)
9. [08_api-integrationen.md](./08_api-integrationen.md)
10. [09_business-logik.md](./09_business-logik.md)
11. [10_deployment.md](./10_deployment.md)
12. [11_debugging.md](./11_debugging.md)
13. [12_security.md](./12_security.md)
14. [13_tech-debt-offene-punkte.md](./13_tech-debt-offene-punkte.md)
15. [14_handover-checkliste.md](./14_handover-checkliste.md)
16. [15_glossar.md](./15_glossar.md)

## Wenn du nur 10 Minuten hast
- Lies [00_quickstart.md](./00_quickstart.md) komplett.
- Starte lokal mit `composer run dev`.
- Öffne `routes/web.php` und `app/Http/Controllers/` für den Hauptfluss.
- Prüfe das Datenmodell in `database/migrations/` + `app/Models/`.
- Lies [09_business-logik.md](./09_business-logik.md) für die Kernprozesse (Kunde -> Gerät -> Prüfung -> Bericht/Export).
- Lies [13_tech-debt-offene-punkte.md](./13_tech-debt-offene-punkte.md), bevor du größere Änderungen machst.
