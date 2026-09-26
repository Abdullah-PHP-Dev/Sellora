# Sellora — Base44 Development Setup

## Stack
- **Laravel 12** + **Vue 3 (Inertia)** + **Vite 7** + **Tailwind CSS 4**
- **MySQL 8.0** database (migrations use MySQL-specific `SIGNAL SQLSTATE` triggers — SQLite will NOT work)
- **Fortify** for auth, database-based sessions/cache/queue
- No external service credentials required

## Running the app
```bash
docker compose -f docker-compose.base44.yml up -d
```
- Web entry: http://localhost:3000 (Laravel `php artisan serve`)
- Vite dev server: http://localhost:5173 (HMR via `@vite/client`)
- MySQL: internal service `db` on port 3306

## Architecture notes
- **Three services**: `db` (MySQL), `web` (PHP artisan serve on :3000), `vite` (Vite dev on :5173), plus a one-shot `setup` service.
- The `setup` service installs composer/npm deps, creates `.env` from `.env.example` (with MySQL DB settings patched in via sed), generates `APP_KEY`, runs migrations and seeds.
- **Critical**: Laravel's `ServeCommand` strips env vars from the child PHP server process (sets them to `false`) so the child reloads from `.env`. This means compose `env_file` values do NOT reach the web request — the `.env` file must contain the correct DB config. The setup command patches `.env` accordingly.
- **Vite dev URL**: `vite.config.js` sets `server.origin` from `VITE_DEV_SERVER_PUBLIC_URL` env var so the `public/hot` file contains the public HTTPS URL (required for the preview proxy). The `allowedHosts: true` setting accepts the sandbox's rotating hostname.
- MySQL needs `--log-bin-trust-function-creators=1` to allow trigger creation without SUPER privilege.

## Key files
- `docker-compose.base44.yml` — compose runbook
- `Dockerfile.base44` — PHP 8.3 + Node 22 + Composer
- `.env.base44-defaults` — default env vars for compose services (not used for app config due to ServeCommand stripping)
- `vite.config.js` — modified to add `server.origin` and `allowedHosts` for preview compatibility

## Seeded data
- Test user: `test@example.com` (no password set via factory — check `UserFactory` for default)

## Verification
```bash
curl -s -o /dev/null -w "%{http_code}" http://localhost:3000/  # should be 200
curl -s http://localhost:5173/resources/js/app.js               # Vite serving assets
```
