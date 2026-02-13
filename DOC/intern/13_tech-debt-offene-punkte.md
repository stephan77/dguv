# 13 – Tech Debt / Offene Punkte

## Technische Schulden
1. **Fehlende CI/CD** (keine automatisierten Gates).
2. **Kaum Tests** (nur Beispieltests, keine Domänentests).
3. **Keine Rollen/Policies** für fein-granulare Berechtigungen.
4. **Uneinheitliche Validierungsstrategie** (FormRequest + Inline-Validation gemischt).
5. **Teilweise fehlende Typsicherheit/Code-Stil-Konsistenz** in Controllern.

## Riskante Stellen
- Öffentliche Device-Route kann Datenleck verursachen, wenn Geräte-IDs erratbar sind.
- CSV-Parser ist formatabhängig; Änderungen im ST725-Export können stillschweigend falsche Zuordnungen erzeugen.
- `settings`-Toggle erwartet vorhandenen Datensatz `registration_enabled`.

## Unklare Logik
- Wie und wann `settings.registration_enabled` initial angelegt wird: im Repo nicht sauber initialisiert.
- Domänenregeln zu Prüfstandards und Bewertungslogik nur partiell kodiert.

## Priorisierte TODO-Liste
1. **P1:** Fachliche Feature-/Integrationstests für Kernflow (Customer->Device->Inspection->Export).
2. **P1:** RBAC/Policies einführen.
3. **P1:** CI Workflow mit Test + Pint + Security Checks.
4. **P2:** Settings-Seed/Migration-Default für `registration_enabled`.
5. **P2:** Import-Validierung + Fehlerreporting verbessern.
6. **P3:** Dokumentierte Deployment-Pipeline ergänzen.

## Nicht anfassen ohne Refactor
- `St725CsvParser` Mapping-Indices nicht ändern ohne Testdaten-Suite und Rückwärtskompatibilitätscheck.
- Prüfintervall-Berechnung (`next_inspection`) nicht an mehreren Stellen divergieren lassen; zentralisieren bevor erweitert wird.
