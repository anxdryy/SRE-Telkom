# Deploying to Hostinger (shared hosting, manual upload)

This app is plain Laravel — no queue workers, no websockets — so it runs fine
on Hostinger's shared Premium plan. These steps assume you're uploading via
hPanel's File Manager or an FTP client, not Git deploy or SSH.

## 1. Create the MySQL database

In hPanel: **Databases → MySQL Databases** → create a database and a user,
add the user to the database with all privileges. Note the four values
Hostinger gives you: database name, username, password, host (usually
`localhost` or `127.0.0.1`).

## 2. Build locally

From the project root, on your own machine (not on Hostinger):

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

`--no-dev` skips test/dev-only packages (phpunit, pail, etc.) — don't run
this in your normal dev checkout if you want to keep working on it; use a
clean copy or a separate build folder.

## 3. Set up your production `.env`

Copy `.env.production.example` to `.env` in your build copy and fill in:

- `APP_KEY` — generate with `php artisan key:generate --show` (run this
  locally with the same PHP version you built with) and paste the output in;
  don't leave it blank.
- `APP_URL` — your real domain, `https://...`
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` — from step 1
- `ADMIN_EMAIL` / `ADMIN_PASSWORD` — your own admin login, not a placeholder

Do **not** upload `.env.production.example` itself to the server — only the
filled-in `.env`, and make sure it's not web-accessible (the root
`.htaccess` this repo ships with already blocks direct access to anything
outside `public/`, so this is handled as long as you upload the whole
project as described below, not just the `public/` folder alone).

## 4. Upload

Upload the **entire project** (everything: `app/`, `bootstrap/`, `config/`,
`database/`, `public/`, `resources/`, `routes/`, `storage/`, `vendor/`,
`.env`, `.htaccess`, `artisan`, `composer.json`, `composer.lock`) into
`public_html/` on Hostinger — so `public_html/public/` ends up containing
Laravel's public folder, not `public_html/` itself.

The root `.htaccess` in this repo (added for this deployment) rewrites every
request into `public/`, so this works without needing to change Hostinger's
document root setting. If your plan *does* let you set a custom document
root per domain (hPanel → **Websites → Manage → Advanced → Document Root**),
you can point it directly at `public_html/public/` instead and skip
uploading the root `.htaccess` — either approach works, don't do both.

`node_modules/` does **not** need to be uploaded — only the built
`public/build/` output from step 2.

After upload, make sure `storage/` (and everything inside it) is writable by
the web server — in hPanel File Manager or your FTP client, set permissions
to `755` recursively on `storage/`, and try `775` if logs, sessions, or
uploads still fail with permission errors afterward. `bootstrap/cache/`
needs the same treatment if `config:cache`/`route:cache` fail.

## 5. Run the one-time setup

**Fill in `.env` completely first (step 3) before doing anything below** —
`config:cache` snapshots whatever is in `.env` at the moment it runs; if you
cache placeholder values and then edit `.env` afterward, the edits won't
take effect until you clear the cache and re-cache.

**If you have terminal access** (hPanel → **Advanced → SSH Access** or
**Terminal**, available on most plans): `cd` into your project root and run:

```bash
php artisan migrate --force
php artisan storage:link
php artisan db:seed --class=AdminUserSeeder
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**If you don't have terminal access**, skip `migrate`/`db:seed` entirely and
import the schema + admin account via phpMyAdmin instead (see
`sretelu-database-seed.sql` and `QUICKSTART.txt` if you have them from a
pre-built `deploy/` folder). You still need `storage:link` to run somehow —
without it, every `Storage::url()` call in the admin views 404s, since
`public/storage` never gets created as a symlink to `storage/app/public`.
The `deploy/` folder ships a `public/one-time-setup.php` script for exactly
this: visit it once with its token as a query parameter, confirm it reports
success, then **delete the file from the server immediately** — it's gated
by a token, but a script that runs artisan commands over plain HTTP
shouldn't be left in place longer than it takes to use it once.

## 6. Verify

Give Hostinger's free SSL a few minutes to finish provisioning after you
point the domain here (hPanel → **SSL** should show "Active") before
testing login. `.env` sets `SESSION_SECURE_COOKIE=true`, so the login
session cookie is only sent over HTTPS — logging in while the site is still
serving plain `http://` will silently redirect you back to the login form
instead of an error, which looks like a bug but isn't.

Once SSL is active, visit `https://your-domain.com/admin`, log in with the
`ADMIN_EMAIL` / `ADMIN_PASSWORD` you set in step 3, and confirm the six
resources (Departments, Members, Categories, Programs, Works, Alumni) all
load and that creating a record with an image upload works end-to-end.

## Notes

- `APP_DEBUG` must be `false` in production (`.env.production.example`
  already sets this) — leaving it `true` exposes stack traces (including
  `.env` values) to any visitor who hits an error page.
- If you ever re-upload after a code change, re-run
  `php artisan config:cache` (or `config:clear` if you're troubleshooting
  and want live `.env` reads instead of the cached config).
- Session/cache/queue all use the `database` driver in
  `.env.production.example`, which just needs the `sessions`, `cache`, and
  `jobs` tables — already covered by `php artisan migrate`, and already
  present in `sretelu-database-seed.sql` if you used the phpMyAdmin import
  path instead.
