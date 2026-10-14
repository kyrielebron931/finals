# Folioform

Folioform is a Laravel portfolio builder with registration and login, portfolio information management, three selectable designs, private previews, and public share links.

## Local development

Requirements: PHP 8.3+, Composer, and the PHP SQLite extension.

```sh
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan storage:link
php artisan serve
```

Open `http://127.0.0.1:8000`. Run the automated checks with `php artisan test`.

See [PROJECT_DOCUMENTATION.md](PROJECT_DOCUMENTATION.md) for the project overview, technologies, database structure, templates, deployment details, and screenshot checklist.

## Railway deployment

The repository includes a Dockerfile with the PostgreSQL PHP driver and Railway configuration. Create a Railway project, add a PostgreSQL service, and deploy this repository as a web service. Set these web-service variables:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` to the output of `php artisan key:generate --show` (run locally; do not commit it)
- `APP_URL` to the Railway public HTTPS URL
- `DB_CONNECTION=pgsql`
- `DB_URL` to the PostgreSQL service URL, for example `${{Postgres.DATABASE_URL}}`

Enable a Railway public domain for the web service. The container runs database migrations and creates Laravel's public-storage link on startup. To keep uploaded profile pictures across deploys and restarts, attach a Railway volume at `/var/www/html/storage/app/public`. Without a volume, PostgreSQL records persist but uploaded files use the container's ephemeral filesystem.

The public portfolio URL is `/p/{slug}`. Portfolio records are private to their owner for editing and deletion; anyone with a public share URL can view its published portfolio.