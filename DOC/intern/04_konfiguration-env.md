# 04 – Konfiguration / ENV

Quelle: `.env.example` + Standard-Laravel-Config (`config/*.php`).

## ENV-Variablen (im Repository sichtbar)

| Name | Bedeutung | Beispielwert | Default/Required | Verwendung |
|---|---|---|---|---|
| APP_NAME | Anzeigename der App | Laravel | Default vorhanden | `config/app.php` |
| APP_ENV | Laufzeitumgebung | local | Default vorhanden | `config/app.php` |
| APP_KEY | Laravel Encryption Key | base64:... | **erforderlich** | `config/app.php` |
| APP_DEBUG | Debug-Ausgaben | true | Default vorhanden | `config/app.php` |
| APP_URL | Basis-URL | http://localhost | Default vorhanden | `config/app.php` |
| APP_LOCALE | Locale | en | Default vorhanden | `config/app.php` |
| APP_FALLBACK_LOCALE | Fallback-Locale | en | Default vorhanden | `config/app.php` |
| APP_FAKER_LOCALE | Faker-Locale | en_US | Default vorhanden | `config/app.php` |
| APP_MAINTENANCE_DRIVER | Wartungsmodus-Driver | file | Default vorhanden | `config/app.php` |
| APP_MAINTENANCE_STORE | Wartungs-Store | database | Optional | `config/app.php` |
| BCRYPT_ROUNDS | Hash-Cost | 12 | Default vorhanden | Hashing/Framework |
| LOG_CHANNEL | Log-Kanal | stack | Default vorhanden | `config/logging.php` |
| LOG_STACK | Stack-Kanäle | single | Default vorhanden | `config/logging.php` |
| LOG_DEPRECATIONS_CHANNEL | Deprecation-Logziel | null | Default vorhanden | `config/logging.php` |
| LOG_LEVEL | Log-Level | debug | Default vorhanden | `config/logging.php` |
| DB_CONNECTION | DB-Treiber | sqlite | Default vorhanden | `config/database.php` |
| DB_HOST | DB Host | 127.0.0.1 | Optional | `config/database.php` |
| DB_PORT | DB Port | 3306 | Optional | `config/database.php` |
| DB_DATABASE | DB Name/Datei | database/database.sqlite | Optional bei sqlite-Default | `config/database.php` |
| DB_USERNAME | DB User | root | Optional | `config/database.php` |
| DB_PASSWORD | DB Passwort | (leer) | Optional | `config/database.php` |
| SESSION_DRIVER | Session-Backend | database | Default vorhanden | `config/session.php` |
| SESSION_LIFETIME | Sessiondauer Min. | 120 | Default vorhanden | `config/session.php` |
| SESSION_ENCRYPT | Session Encryption | false | Default vorhanden | `config/session.php` |
| SESSION_PATH | Session-Pfad | / | Default vorhanden | `config/session.php` |
| SESSION_DOMAIN | Session-Domain | null | Optional | `config/session.php` |
| BROADCAST_CONNECTION | Broadcast-Driver | log | Default vorhanden | `config/broadcasting.php` (Laravel-Standard) |
| FILESYSTEM_DISK | Standard-Dateisystem | local | Default vorhanden | `config/filesystems.php` |
| QUEUE_CONNECTION | Queue-Connection | database | Default vorhanden | `config/queue.php` |
| CACHE_STORE | Cache Store | database | Default vorhanden | `config/cache.php` |
| CACHE_PREFIX | Cache Prefix | (leer) | Optional | `config/cache.php` |
| MEMCACHED_HOST | Memcached Host | 127.0.0.1 | Optional | `config/cache.php` |
| REDIS_CLIENT | Redis Client | phpredis | Default vorhanden | `config/database.php` |
| REDIS_HOST | Redis Host | 127.0.0.1 | Default vorhanden | `config/database.php` |
| REDIS_PASSWORD | Redis Passwort | null | Optional | `config/database.php` |
| REDIS_PORT | Redis Port | 6379 | Default vorhanden | `config/database.php` |
| MAIL_MAILER | Mailer | log | Default vorhanden | `config/mail.php` |
| MAIL_SCHEME | Mail Scheme | null | Optional | `config/mail.php` |
| MAIL_HOST | Mail Host | 127.0.0.1 | Optional | `config/mail.php` |
| MAIL_PORT | Mail Port | 2525 | Optional | `config/mail.php` |
| MAIL_USERNAME | Mail User | null | Optional | `config/mail.php` |
| MAIL_PASSWORD | Mail Passwort | null | Optional | `config/mail.php` |
| MAIL_FROM_ADDRESS | Sender-Adresse | hello@example.com | Default vorhanden | `config/mail.php` |
| MAIL_FROM_NAME | Sender-Name | ${APP_NAME} | Default vorhanden | `config/mail.php` |
| AWS_ACCESS_KEY_ID | AWS Key | (leer) | Optional | `config/filesystems.php`, `config/services.php` |
| AWS_SECRET_ACCESS_KEY | AWS Secret | (leer) | Optional | `config/filesystems.php`, `config/services.php` |
| AWS_DEFAULT_REGION | AWS Region | us-east-1 | Default vorhanden | `config/filesystems.php`, `config/services.php` |
| AWS_BUCKET | AWS Bucket | (leer) | Optional | `config/filesystems.php` |
| AWS_USE_PATH_STYLE_ENDPOINT | S3 Path Style | false | Optional | `config/filesystems.php` |
| VITE_APP_NAME | Frontend Anzeige | ${APP_NAME} | Optional | Frontend (Vite) |

## Profil-/Umgebungsmodell
- `APP_ENV=local` für lokal.
- Stage/Prod-spezifische Env-Dateien sind im Repo **nicht** hinterlegt -> `UNBEKANNT / FEHLT`.
- Secret-Management außerhalb `.env` (Vault/KMS/CI-Secrets) ist **nicht dokumentiert** -> `UNBEKANNT / FEHLT`.
