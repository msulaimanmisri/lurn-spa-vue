# spa-vue

Laravel 12 + Inertia (Vue 3) SPA running on **FrankenPHP** (Caddy) with **Laravel Octane (FrankenPHP server)** in **worker mode**.

## Requirements

- Docker Desktop (or Docker Engine) with `docker compose`
- Node.js (LTS recommended) + npm

## Quick start (first time)

1) Create your `.env`

```bash
cp .env.example .env
```

2) Build frontend assets (required)

This repo ignores `public/build`, so you must generate it locally:

```bash
npm install
npm run build
```

3) Build the Docker image

```bash
docker compose build
```

4) Start database (and optional services)

```bash
docker compose up -d database redis
```

5) Install PHP dependencies, generate app key, run migrations

```bash
docker compose run --rm app composer install
docker compose run --rm app php artisan key:generate
docker compose run --rm app php artisan migrate
```

6) Start the full stack

```bash
docker compose up -d
```

Open:

- App: http://localhost:8000
- phpMyAdmin: http://localhost:8080

## What runs where

- **App server**: FrankenPHP + Caddy + Laravel Octane (FrankenPHP driver)
	- Worker mode is enabled via `php artisan octane:frankenphp` (see `docker-compose.yml`).
	- Auto-reload is enabled via `--watch --poll`.
- **DB**: MariaDB (`database` service)
- **Redis**: `redis` service
- **phpMyAdmin**: `phpmyadmin` service

## Common commands

Start/stop:

```bash
docker compose up -d
docker compose down
```

Logs:

```bash
docker compose logs -f app
```

Run Artisan commands:

```bash
docker compose exec app php artisan about
docker compose exec app php artisan optimize:clear
```

Restart the app (useful after changing `.env`):

```bash
docker compose up -d --force-recreate app
```

Run tests:

```bash
docker compose exec app php artisan test
```

Format PHP:

```bash
docker compose exec app vendor/bin/pint
```

## Notes / Troubleshooting

- If you see a Vite manifest error (missing `public/build/manifest.json`), run `npm run build` again.
- If you change `.env`, restart the `app` container (Octane workers don’t automatically pick up env changes).

## Reference

Original course link (project inspiration):
https://www.udemy.com/course/master-laravel-6-with-vuejs-fullstack-development