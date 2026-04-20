# Butende Brick Works

Laravel application for the public Butende Brick Works website, customer quotation flow, ordering flow, and private admin dashboard.

## Requirements

- PHP 8.3+
- Composer
- Node.js 20+
- SQLite or MySQL

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --force
npm install
```

Run the app locally:

```bash
composer dev
```

## Quality Checks

Run the full repo safety checks before pushing:

```bash
composer qa
npm run build
```

Important commands:

- `php artisan products:sync-calculator-data --dry-run`
  Shows calculator metric issues without changing data.
- `php artisan products:sync-calculator-data`
  Normalizes product calculator data so `coverage_sqm` and `bricks_per_square_metre` stay consistent.
- `php artisan health:check`
  Runs production-oriented dependency checks with a failing exit code if the app is unhealthy.
- `php artisan health:check --json`
  Same health check in machine-readable JSON.

## Calculator Data Integrity

The calculator stores two linked values on each product:

- `bricks_per_square_metre`: units required for `1 m²`
- `coverage_sqm`: area covered by one unit

Admin users should enter `Units per m²` in the product form. The system will derive `coverage_sqm` automatically.

If older data was entered incorrectly, repair it with:

```bash
php artisan products:sync-calculator-data
```

## Monitoring

HTTP health endpoint:

```text
GET /health
```

The endpoint returns:

- `200` when all critical checks pass
- `503` when a critical dependency fails

It checks:

- application key presence
- database connectivity and required tables
- cache round-trip
- writable storage paths
- public storage link presence

Request observability:

- every web response receives an `X-Request-Id` header
- exceptions include request context in logs
- slow requests and server-error responses are written to the `monitoring` log stack

Useful monitoring env vars:

- `APP_RELEASE`
- `LOG_MONITORING_CHANNELS`
- `SLOW_REQUEST_THRESHOLD_MS`

Console health monitoring:

```bash
php artisan health:check --json
```

The app also schedules `health:check --json` every 5 minutes. Make sure the Laravel scheduler is running in production:

```bash
* * * * * php /path/to/project/artisan schedule:run >> /dev/null 2>&1
```

If you configure `LOG_MONITORING_CHANNELS`, failed health checks will be logged to that stack.

## Public Form Hardening

The public `talk-to-us` and quote forms now include:

- per-IP and per-email throttling
- a honeypot field that silently drops obvious bot submissions
- request-id logging for suspicious form traffic

If you need to tune the limits, update:

- `TALK_TO_US_PER_MINUTE`
- `TALK_TO_US_PER_HOUR`
- `TALK_TO_US_HONEYPOT_FIELD`

## Deployment

Recommended deployment flow:

```bash
git pull
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan products:sync-calculator-data
php artisan health:check
php artisan storage:link
```

Post-deploy smoke test:

- `/`
- `/products`
- `/products/bricks`
- `/brick-calculator`
- `/health`

## CI

GitHub Actions runs the following on every push and pull request:

- `composer validate`
- dependency installation
- database migrations
- calculator data dry-run audit
- production health check
- Pest test suite
- Vite production build

Workflow file:

- [.github/workflows/ci.yml](.github/workflows/ci.yml)
