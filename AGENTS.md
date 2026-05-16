# Tokokopi — Laravel 12 project

## Dev setup
- **Full setup:** `composer run setup` (installs PHP & Node deps, copies `.env`, generates key, runs migrations, builds assets)
- **Dev server:** `composer run dev` (runs `artisan serve`, queue listener, logs, and Vite concurrently)
- **Build frontend:** `npm run build` or `npm run dev` (Vite + Tailwind CSS v4 via `@tailwindcss/vite`)
- **PHP code style:** `./vendor/bin/pint` (Laravel Pint, no custom config)
- **Tests:** `composer run test` (runs `artisan config:clear` then `artisan test` — PHPUnit 11)
  - Tests use SQLite `:memory:`, no external DB needed
  - `tests/Unit/` extends `PHPUnit\Framework\TestCase`
  - `tests/Feature/` extends `Tests\TestCase` (which extends `Illuminate\Foundation\Testing\TestCase`)
  - Add `RefreshDatabase` trait to feature tests that need DB

## Architecture
- **Routes:** `routes/web.php` (web), `routes/console.php` (Artisan commands). No API routes registered.
- **Entrypoint:** `bootstrap/app.php` configures routing, middleware, and exceptions.
- **Default DB:** MySQL (`db_tokokopi`). Tests use SQLite `:memory:` (no external DB needed). Session, cache, and queue all default to `database` driver.
- **Auth stack:** Laravel's built-in auth via `App\Models\User` (extends `Authenticatable`). No Breeze/Jetstream installed.
  - Login page: `/login` (GET/POST), logout: `POST /logout` (route name `login`)
  - Default admin: `admin@tokokopi.com` / `admin123` (from `DatabaseSeeder`)
- **Frontend:** Blade templates (`resources/views/`) with Vite + Tailwind CSS v4. Inertia/React/Vue not installed.
  - `resources/views/pos.blade.php` — POS cashier page at `/` (public)
  - `resources/views/admin.blade.php` — admin CRUD at `/admin` (auth required)
  - `resources/views/nota.blade.php` — receipt/print page at `POST /nota` (auto-prints on load)
  - `resources/views/login.blade.php` — login form
- **POS workflow:** Products listed on `/`, click to add to JS cart → adjust qty → submit to `/nota` → auto `window.print()`
- **Models:** `App\Models\Product` (`products` table: `id, nama_kopi, harga, timestamps`)
- **Factories/Seeders:** `database/factories/UserFactory.php`, `database/factories/ProductFactory.php`, `database/seeders/DatabaseSeeder.php`
- Note: Run `npm run build` before tests or deploy so Vite manifest exists (needed by `@vite()` in Blade views)

## Security (already applied — do not regress)

### XSS prevention
- Never pass user content inline in `onclick="..."` attributes. Always use `data-*` attributes + `this.dataset`. See `pos.blade.php` and `admin.blade.php` for the safe pattern.
- Blade `{{ }}` auto-escapes for HTML, but HTML entities are decoded inside `onclick` handlers, making inline interpolation unsafe.

### Price manipulation prevention
- `CashierController@nota` ignores client-sent `harga` and looks up the real price from the database by product ID. Any price sent from the client is rejected.

### CSRF
- Every state-changing form (POST/PUT/DELETE) includes `@csrf`. Laravel's `VerifyCsrfToken` middleware covers all routes by default.

### File upload
- Product photos are validated with `image|mimes:jpeg,png,jpg|max:2048`. Stored in `storage/app/public/products/` (outside PHP execution path). Requires `php artisan storage:link` on fresh setup.

### Authentication
- Admin routes (`/admin`) are protected by `Route::middleware('auth')`. POS (`/`) and nota (`/nota`) are intentionally public.

## Code conventions
- PSR-4: `App\` → `app/`, `Database\Factories\` → `database/factories/`, `Database\Seeders\` → `database/seeders/`, `Tests\` → `tests/`
- EditorConfig: 4-space indent (2 for yaml), LF line endings, UTF-8
- Use Laravel facades, helpers, and Eloquent conventions (follow existing `User.php` patterns)
