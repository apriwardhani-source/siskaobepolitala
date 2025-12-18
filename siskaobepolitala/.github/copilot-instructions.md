## Quick orientation

- Repository type: Laravel (PHP ^8.2, Laravel 12) with a companion Node service used for WhatsApp integration.
- Key runtime pieces:
  - PHP app: `app/` (Controllers, Models, Services, Console commands)
  - Node WhatsApp service: `whatsapp-service.cjs` + PM2 config `ecosystem.config.cjs`
  - Exports/Imports: `app/Exports/*` and artisan commands under `app/Console/Commands`

## High-level architecture (what to know first)
- Laravel handles web UI, API endpoints, scheduled tasks and database work. Business logic often lives in `app/Services` (e.g. `WhatsAppService.php`, `SawCalculationService.php`).
- Long-running WhatsApp integration is a separate Node process (whatsapp-web.js) started under PM2; Laravel calls it or communicates via HTTP -> the Node service exposes `/status`, `/qr` and `/send` endpoints.
- Data sync pattern: team shares simple JSON DB dumps in `storage/app/database-exports` using `php artisan db:export` and `php artisan db:import` to sync environments.

## Developer workflows & important commands
- Prepare environment:
  - Copy .env example: `copy .env.example .env` and set DB and WHATSAPP_* env vars.
  - Install PHP deps: `composer install` (requires PHP 8.2+)
  - Install JS deps: `npm install`

- Common commands (PowerShell / Windows):
  - Start Laravel dev stack (as defined in `composer.json` `dev` script):
    - `composer dev` (runs `php artisan serve`, queue listener, pail, and `npm run dev` via concurrently)
  - Serve only PHP app: `php artisan serve`
  - Run tests: `./vendor/bin/phpunit` or `vendor\bin\phpunit` from PowerShell

- WhatsApp service (Node + PM2):
  - Start via PM2: `pm2 start ecosystem.config.cjs` (PM2 config is `ecosystem.config.cjs` in repo root).
  - From Laravel there's a console helper: `php artisan whatsapp:service start|stop|restart|status` (note: the command currently calls `pm2 start ecosystem.config.js` — the repo file is `.cjs`; prefer `ecosystem.config.cjs` when running manually).
  - QR code UI: `http://localhost:3001/qr` (see `whatsapp-service.cjs`)

## Data export/import conventions (important)
- Exports created with `php artisan db:export` are stored at `storage/app/database-exports/*.json`.
- The importer `php artisan db:import` expects certain primary keys per table (see `ImportDatabase.php`):
  - `mahasiswas` => `nim`
  - `mata_kuliahs` => `kode_mk`
  - `prodis` => `kode_prodi`
  - `tahun` => `id_tahun`
  - `nilai_mahasiswa` => `id_nilai`
  - `dosen_mata_kuliah` => `id`
  - `users` => `id`
  - `capaian_profil_lulusans` => `id_cpl`
  - `bahan_kajians` => `id_bk`
  - `capaian_pembelajaran_mata_kuliahs` => `id_cpmk`
- Use `--fresh` to truncate before import and `--tables=mahasiswas,mata_kuliahs` to limit scope.

## Project-specific conventions & patterns
- Services pattern: put stateless business logic into `app/Services/*`. Controllers call service methods rather than embedding logic.
- Export classes: `app/Exports/*` use the Maatwebsite Excel patterns — use these for spreadsheet outputs.
- Long-running processes are managed outside PHP (PM2 + Node) — Laravel only triggers or queries status.

## Integration & external dependencies to watch
- Node/PM2: `whatsapp-service.cjs`, `ecosystem.config.cjs`, and `package.json` (whatsapp-web.js, puppeteer). Ensure headless Chrome dependencies are available on the host.
- Evolution API: `app/Services/WhatsAppService.php` can proxy to an Evolution API (ENV: `EVOLUTION_API_URL`, `EVOLUTION_API_KEY`).
- Excel/word libs: `maatwebsite/excel`, `phpoffice/phpword` — used for exports.

## Files to open first when investigating a behavior
- `app/Services/WhatsAppService.php` — message sending and dev toggle (WHATSAPP_ENABLED).
- `whatsapp-service.cjs` + `ecosystem.config.cjs` — Node side of WhatsApp flow (QR, send endpoints).
- `app/Console/Commands/ExportDatabase.php` and `ImportDatabase.php` — custom import/export behavior and primary key mapping.
- `app/Services/SawCalculationService.php` — example of numeric business logic and DB writes (SAW ranking algorithm).

## Small gotchas discovered
- The artisan command calls `pm2 start ecosystem.config.js` while the repo has `ecosystem.config.cjs` — prefer `.cjs` or adjust the command when using PM2 manually.
- WhatsApp features can be toggled via `WHATSAPP_ENABLED` in `.env` — helpful for development to avoid sending messages.

If anything above is unclear or you want additional examples (e.g., common HTTP endpoints, DB table lists, or the exact env vars to set), tell me which area to expand and I will iterate.
