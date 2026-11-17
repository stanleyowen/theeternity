# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Eternity Esports: a 2020 PHP scrim-management site (player dashboard + admin console, EN/ID), restored in 2026 as a
**read-only archive** with the original design kept and the internals rebuilt securely. Plain PHP 8.5, no framework,
no Composer, no build step. Front-end libraries are vendored in `assets/vendor/`.

## Commands

PHP is not installed on the host; everything runs through Docker.

```bash
docker compose up -d --build                     # archive mode at http://localhost:8080 (rebuild after ANY code change)
python3 tests/smoke_test.py archive http://localhost:8080

# live (writable) mode for testing writes; APP_KEY is required or the entrypoint exits
KEY=$(python3 -c "import os,base64;print(base64.b64encode(os.urandom(32)).decode())")
docker build -t eternity:dev . && docker run -d --name eternity-live -p 8090:80 \
  -e ARCHIVE_MODE=false -e APP_KEY=$KEY -e APP_ENV=development eternity:dev
echo "smoke-admin-password-123" | docker exec -i -u www-data -e APP_KEY=$KEY eternity-live php bin/create-admin.php "Smoke Admin"
python3 tests/smoke_test.py live http://localhost:8090

# lint all PHP
docker run --rm -v "$PWD":/app -w /app php:8.5-apache sh -c 'for f in $(find . -name "*.php" -not -path "./assets/*"); do php -l "$f" >/dev/null || php -l "$f"; done'
```

- `tests/smoke_test.py` is stdlib-only end-to-end HTTP testing; the first argument selects the suite (`archive` or
  `live`). There is no per-test selector. When adding a page, add it to the `PUBLIC_PAGES` / `PLAYER_PAGES` /
  `ADMIN_PAGES` lists there; the suites check every listed page returns 200 with no PHP warnings.
- `APP_ENV=development` shows stack traces; production hides them and renders `global-error/500.php`.
- The SQLite archive DB is **baked into the image at build time** (`bin/init-db.php --fresh --seed`), so schema or
  seed changes need a rebuild.
- **Static deploy (Netlify):** `tools/export-static.sh` runs the image with `STATIC_EXPORT=true` and crawls it
  with `tools/export_static.py` into `dist/` (committed; `netlify.toml` publishes it with no build step).
  `dist/` is generated output: never edit it by hand, and re-run the export after changing pages, CSS/JS or seed
  data. The exporter exits non-zero on dead links, unmapped URLs or PHP warnings. New pages are picked up only if
  something links to them (or they are added to `SEEDS` in the exporter).
- `STATIC_EXPORT` only changes a few helpers (`csrf_field()`, `logout_url()`, `demo_access_panel()`, `body_attrs()`)
  and lets `demo-login.php` accept GET for the exporter. Keep it off on any server reachable from outside.
- Docker production: `docker-compose.prod.yml` runs behind a Cloudflare Tunnel, bound to `127.0.0.1:8080` with
  `TRUST_PROXY=true`. Never bind it to `0.0.0.0`: trusting `CF-Connecting-IP` / `X-Forwarded-*` is only safe while the
  tunnel is the sole way in.

## Architecture

**Every PHP entry point starts with `require .../app/bootstrap.php`.** It loads all of `app/` (config, db, security,
i18n, auth, uploads, views, forms), starts the hardened session, sends security headers (including a strict CSP), and
runs two **central guards on every POST**:
1. CSRF: `_csrf` must match the session token, so every form needs `<?= csrf_field() ?>`.
2. Archive gate: when `ARCHIVE_MODE=true` (the default), all POSTs are refused with a flash message, unless the
   script defines `ALLOW_IN_ARCHIVE` before the require (only `global-validation/demo-login.php` and `logout.php` do).

As a second layer, `app/db.php` opens SQLite read-only (MySQL: read-only transaction) in archive mode. Only `bin/`
CLI scripts define `DB_WRITABLE`. Handlers therefore never check CSRF or archive mode themselves.

**URLs are the original 2020 paths** and must be preserved:
- `en-us/` and `id/`: page files per language.
- `function/*.php`: POST-only action handlers. They start with `require_post()`, then `require_admin()` or
  `require_player()`, and end with `flash_back($msg, $fallbackPath)` or `flash()` + `redirect()`.
- `global-validation/`: logout, the "Join Scrim" redirect, and demo login.

**Language duplication is intentional.** Shared chrome (nav, footer, sidebars, archive notices) comes from `t()` in
`app/i18n.php` and the partials in `app/views.php`. Page prose is hard-coded separately in the `en-us/` and `id/`
files, so content changes to a player or public page usually need the same edit in both. The admin console exists
only in English (`en-us/dashboard/admin/`); `id/dashboard/admin/dashboard-admin.php` just redirects.

**Two themes:**
- Public pages: Bootstrap 4. They use `public_header()`, `public_nav()` and `public_footer()`.
- Dashboards: Bootstrap 3. They use `dashboard_header($title, 'player'|'admin', $activeKey, $user)`, content inside
  `<div class="col-sm-9">`, then `dashboard_footer()`.

Keep the 2020 markup and CSS as they are; that is the point of the archive. New styling goes in
`assets/css/dashboard-extra.css` or the marked section at the end of `assets/css/style.css`.

**No inline JavaScript (the CSP blocks it).** Behaviour lives in `assets/js/app.js` and is wired through data
attributes:
- `data-flash` on `<body>` carries server flash messages, shown with `alert()` like the original site.
- `data-confirm` on forms asks for confirmation.
- `data-href` on buttons navigates.
- `data-back` on links goes back in history.

Destructive actions are small POST forms built with `action_button()`, never GET links.

**Output and data rules used throughout:**
- Output: escape every dynamic value with `e()` / `e_multiline()`. Links go through `safe_url()` /
  `validate_url()`, which allow only http(s).
- Database: all SQL uses `db_query` / `db_all` / `db_one` / `db_value` with bound parameters.
- Paths: build them with `url()`, `asset()` and `lang_url()`, which handle sub-directory deploys. Don't use relative
  `../` paths.
- Auth: the role comes from the DB on every request (`current_user()`). Player pages 2–6 also call
  `require_membership()`, which replaced the old JScrim cookie.
- "Once only" rules (results, uploads, attendance, feedback) are enforced in the DB, via conditional updates or the
  `rate_limits` table, never with cookies.

**Uploads:**
- Validation and storage: `store_image_upload()` sniffs the type, re-encodes the image with GD, gives it a random
  32-hex name, and stores it in `storage/uploads/<bucket>/`, outside the web root.
- Serving: files are served only through `media.php?b=&f=`. The `gallery` bucket is public; the others are admin-only.
- Deleting: handlers that delete rows must also call `delete_upload()`.

**Data:**
- Schema exists twice, in `database/schema.sqlite.sql` (default) and `database/schema.mysql.sql`; keep them in sync.
- `database/seed.php` holds representative archive data (the 2020 DB is gone). Seeded accounts have unusable
  passwords; visitors enter as "Demo Squad" or "Eternity Admin" through demo sessions.
- Contact-form name, email and comment are AES-256-GCM encrypted (`encrypt_text` / `decrypt_text`) with `APP_KEY`.

**Never web-accessible:** `app/`, `bin/`, `database/`, `storage/`, `docker/` and dotfiles. This is enforced by
`docker/apache.conf` (Docker) and by `.htaccess` (shared hosting fallback). Keep both in sync when adding internal
directories.
