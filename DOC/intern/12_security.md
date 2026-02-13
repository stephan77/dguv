# 12 – Security

## AuthN / AuthZ
- Login/Logout via Laravel Auth-Flow (`AuthenticatedSessionController`).
- Register-Endpoint vorhanden, aber per `settings.registration_enabled` abschaltbar.
- Route-Schutz primär über `auth` Middleware.
- Rollen/Rechte (Policies/Gates/RBAC) nicht gefunden -> `UNBEKANNT / FEHLT`.

## Secrets
- Secrets lokal in `.env`.
- `.env.example` enthält Platzhalter.
- Externes Secret Management nicht dokumentiert -> `UNBEKANNT / FEHLT`.

## Input Validation
- FormRequests für zentrale Inputs (`CustomerRequest`, `DeviceRequest`, `InspectionRequest`, Import-Requests, Auth-Requests).
- In einigen Controllern direkte `$request->validate(...)` Nutzung (User/TestDevice).

## Kritische Angriffsflächen
- Öffentliche Geräteansicht (`/public/device/{device}`) ist ohne Auth erreichbar.
- Datei-Upload beim CSV-Import (`mimes:csv,txt`) – Content Parsing robust halten.
- Exporte/Berichte liefern potenziell sensible Daten (nur hinter auth).

## Sicherheitsrelevante Tests/Scans
- Keine Security-Scan- oder DAST/SAST-Pipeline im Repo gefunden -> `UNBEKANNT / FEHLT`.
