# 10 – Deployment

## Zielumgebungen
- Im Repository keine expliziten Deploy-Definitionen (Docker/K8s/Terraform/CI) gefunden.
- Daher Infrastrukturziel (VM/K8s/Serverless) -> `UNBEKANNT / FEHLT`.

## CI/CD Flow
- Keine Workflow-Dateien (`.github/workflows`, `.gitlab-ci.yml`, Jenkinsfile) gefunden.
- Automatisierte Build/Test/Deploy-Pipeline -> `UNBEKANNT / FEHLT`.

## Artifacts
- Potenzielle Artifacts (implizit):
  - gebautes Frontend in `public/build`
  - Exportdateien (PDF/XLSX) zur Laufzeit
- Konkrete Release-Artefaktstrategie ist nicht dokumentiert.

## Release/Versioning
- Kein formales Versioning-Schema (Tags/Changelog-Policy) im Repo dokumentiert -> `UNBEKANNT / FEHLT`.

## Rollback
- Kein dokumentierter Rollback-Prozess -> `UNBEKANNT / FEHLT`.

## Secrets Handling
- Lokal via `.env`.
- Produktions-Secrets-Management (z. B. Vault, CI Secret Store) nicht im Repo beschrieben -> `UNBEKANNT / FEHLT`.
