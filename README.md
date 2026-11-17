# Eternity Esports

> **Archived project.** Eternity Esports was a PUBG Mobile scrim community founded in 2019 in Medan, Indonesia.
> This website ran its scrims: squad registration, attendance tokens, result submission, proof uploads and
> e-certificates, with a full admin console. The club is no longer active. The site is preserved here as a
> read-only archive so it stays online.

Built in 2020 by [Stanley Owen](https://www.instagram.com/stanleyowennn/) with HTML, CSS, JavaScript, PHP and MySQL.
In 2026 it was restored as an **Archive Edition**. The original design and copy are unchanged. The engine underneath
was rebuilt to current security standards.

---

## What the site does

**For players**
- Multi-language UI (English / Bahasa Indonesia)
- Squad registration and login
- Six-step scrim flow: participate → join WhatsApp group → upload squad logo and Instagram proofs → attendance with a
  scrim token → submit match results → download e-certificates
- Contact form with encrypted storage

**For administrators**: 20+ management features
- Posts (public, or hidden behind a private code), site-wide alert bars, gallery
- Scrim events and attendance tokens, participants and their uploads, attendance list
- Match results (two matches per scrim), certificate links, user accounts, inbox

## Archive mode

The site runs in **archive mode** by default (`ARCHIVE_MODE=true`):

- Every page is visible, including the dashboards. Visitors open them through **"View as Player" /
  "View as Administrator"** on the login page. These are demo sessions with seeded 2020-style data.
- Every state-changing request is refused at one central choke point (`app/bootstrap.php`), and the SQLite database
  is opened **read-only**. The archive cannot be modified even if a code path were missed.
- A small "Archived" tag and notice appear on every page, linking to the archive release notes.

Set `ARCHIVE_MODE=false` to run the fully working site.

## 2026 security rework

The 2020 code shipped with problems that would be critical on any live site. Each one is fixed:

| 2020 build | Archive Edition |
|---|---|
| Auth guards called `header('Location')` **without `exit`**. Anyone could run admin actions (delete users, wipe tables) without logging in | Guards always terminate; every page and action checks the role on the server |
| Username and **plaintext password stored in cookies** for 30 days, and accepted as a login | Opaque session id only (`HttpOnly`, `SameSite=Lax`, `Secure` on HTTPS), regenerated on login |
| The **login form let the user choose "Administrator"** | Role comes from the database only |
| Passwords hashed with `sha1(crypt())` and a static salt | `password_hash()` (bcrypt), with automatic rehash |
| Stored **XSS** on nearly every page, including the admin console | Every value is escaped; strict **Content-Security-Policy** (`script-src 'self'`, no inline JS) |
| SQL built by string concatenation (`mysqli_real_escape_string` on some inputs) | PDO **prepared statements** everywhere |
| Deletes were **GET links** with no CSRF protection | CSRF token checked on every POST; destructive actions are confirmed POST forms |
| AES-256-CBC with an **empty IV** (deterministic, unauthenticated), "encrypting" usernames | AES-256-GCM with random IVs, used only for contact-form personal data |
| Gallery upload had **no auth check at all**. Uploads kept the client's filename, extension-only check, stored in the web root | Admin-only. MIME sniffing + real image decode + GD re-encode, random names, stored outside the web root, served by `media.php` with access control |
| "Submit once" and rate limits enforced with **client cookies** | Enforced in the database; login, register, feedback and attendance tokens are throttled |
| Secrets hard-coded in PHP; dead `000webhostapp.com` URLs and cookie domains | Environment config; no hard-coded hosts |
| jQuery 1.8.2 / 3.5.1, Bootstrap 4.5.0, Bootstrap 3 from the retired MaxCDN | jQuery 3.7.1, Bootstrap 4.6.2 / 3.4.1, Font Awesome 4.7, all self-hosted (same major versions, so the design is pixel-identical) |
| Right-click and DevTools-key blocking presented as security | Removed: it protected nothing and hurt accessibility |
| — | Security headers (CSP, `X-Frame-Options`, `nosniff`, Referrer/Permissions-Policy, HSTS on HTTPS), hardened `php.ini` and Apache config |

Unused endpoints (`add-participant`, `add-present-participant`, `delete-event-ALL`) were deleted.
Inconsistent behaviour was fixed along the way. For example, "Delete" on a match result now clears that result
instead of removing the whole squad.

## Run it

Requires Docker.

```bash
docker compose up --build
# open http://localhost:8080
```

The image (PHP 8.5 + Apache) bakes the read-only archive database in at build time. It runs with a read-only root
filesystem, so it can be deployed as-is to any container host (Render, Fly.io, Railway, Cloud Run…). `$PORT` is
respected.

### Deploy on your own server (Ubuntu)

The site runs in one container behind a [Cloudflare Tunnel](https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/).
Cloudflare terminates HTTPS, the server opens **no inbound ports**, and the container listens on `127.0.0.1` only.

```bash
# on the server (Docker Engine + compose plugin installed)
git clone https://github.com/stanleyowen/theeternity.git && cd theeternity

# A) cloudflared already runs on the host: point the tunnel's public hostname at http://localhost:8080
docker compose -f docker-compose.prod.yml up -d --build

# B) or run cloudflared in Docker as well: create a tunnel in the Zero Trust dashboard,
#    set its public hostname service to http://web:80, and pass its token
TUNNEL_TOKEN=<token> docker compose -f docker-compose.prod.yml --profile tunnel up -d --build
```

Updating later: `git pull`, then run the same `up -d --build` command again.

`TRUST_PROXY=true` is set so the app reads the visitor's IP from `CF-Connecting-IP` and sees the HTTPS scheme. This is
safe only because the port is bound to localhost and reachable solely through the tunnel. Keep it that way. (Docker
publishes ports around `ufw`, so a `0.0.0.0` binding would expose the app directly.)

### Static hosting (Netlify, Cloudflare Pages) — no backend

Because the archive is read-only, every page can be rendered once and published as plain files. Nothing runs on the
server, so there is nothing to patch or attack.

```bash
tools/export-static.sh     # needs Docker; renders every page (incl. both demo dashboards) into dist/
git add dist && git commit -m "Re-export static site" && git push
```

`netlify.toml` publishes `dist/` with no build step. In the static build:
- "View as Player / Administrator" link to pre-rendered dashboards.
- Forms show the "archived" message instead of submitting.
- Query-string pages become separate files (`edit-alert-id.php?id=1` → `edit-alert-id-1.html`).
- Old `.php` URLs redirect via `_redirects`, and the PHP app's security headers are carried over in `_headers`.

**Re-run the export after any change to pages, styles or seed data.** `dist/` is not updated automatically.

### Live (writable) mode

```bash
cp .env.example .env    # set ARCHIVE_MODE=false and an APP_KEY (required in live mode)
docker build -t eternity .
docker run -p 8080:80 --env-file .env -v eternity-data:/var/www/html/storage eternity
docker exec -it <container> php bin/create-admin.php "Your Admin Name"
```

SQLite is the default. For MySQL/MariaDB, set `DB_DSN`, `DB_USER` and `DB_PASS`
(schema: `database/schema.mysql.sql`, applied by `bin/init-db.php`).

### Tests

```bash
python3 tests/smoke_test.py archive http://localhost:8080   # every page renders, writes are refused
python3 tests/smoke_test.py live    http://localhost:8081   # full flows + attack payloads (XSS, SQLi, CSRF, uploads…)
```

## Project layout

```
app/              core: config, PDO, auth, CSRF/escaping/crypto, uploads, layouts, i18n (not web-accessible)
en-us/  id/       pages per language (original URLs preserved)
function/         POST action endpoints
global-error/     error pages
global-validation/ logout, "Join Scrim" redirect, demo sign-in
database/         schemas (SQLite / MySQL) and archive seed data
bin/              CLI: init-db, create-admin
storage/          SQLite database and uploads (not web-accessible)
docker/           Apache / PHP hardening, entrypoint
```

The seeded content (squads, results, messages) is representative sample data. The original 2020 production database
no longer exists.

## License

MIT © 2020 Stanley Owen
