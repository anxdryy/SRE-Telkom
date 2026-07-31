# Admin Redesign + Real Authentication Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the Bootstrap-CDN admin CRUD pages and the hardcoded plaintext login with a Tailwind admin UI that matches the public site's brand, backed by real Laravel authentication (hashed password, session regeneration, login rate limiting).

**Architecture:** Server-rendered Laravel Blade, unchanged. A new shared admin layout (`resources/views/layouts.blade.php`) and a small set of anonymous Blade components (`resources/views/components/admin/*`) replace Bootstrap markup across the six admin resources (Departments, Members, Categories, Programs, Works, Alumni). Authentication moves from a hardcoded username/password array in `AuthController` to Laravel's built-in `Auth` facade against the existing (currently unused) `users` table.

**Tech Stack:** Laravel 11 (Blade, Eloquent), Tailwind CSS via CDN `<script>` (same pattern the public site already uses — see Global Constraints), Font Awesome CDN, PHPUnit Feature tests.

## Global Constraints

- Match the existing admin route names, controller methods, and validation rules exactly — this plan changes **views** and **auth**, not CRUD business logic or field names, unless a step explicitly says otherwise.
- Use Tailwind via the CDN `<script src="https://cdn.tailwindcss.com">` tag, matching how `resources/views/welcome.blade.php` and the current `admin/loginAdmin.blade.php` already load Tailwind. The project has an unused `laravel-vite-plugin` + `resources/css/app.css` pipeline (nothing calls `@vite` anywhere yet), but wiring that up site-wide is a separate, larger follow-up — out of scope here to keep this change contained to admin.
- Brand palette/fonts, copied from the public site (`resources/views/partials/navbar.blade.php`, `resources/views/welcome.blade.php`): primary dark green `#104334`, Tailwind `green-500`/`green-800`/`green-900` for accents, `Red Hat Display` for headings (`font-redhat` class), `Onest` for body text, Font Awesome 6 for icons.
- All 6 admin resources (Department, Member, Category, Programs, Work, Alumni) use UUID primary keys except Alumni, which uses an auto-increment `id`. Route model binding already handles this — don't change it.
- `phpunit.xml` currently points Feature tests at the **real dev SQLite file** (`database/database.sqlite`) because the in-memory overrides are commented out. Task 1 fixes this first — without it, running the new test suite will wipe your local dev data on every run.
- Every new/changed admin view must render inside the shared `layouts.blade.php` (`@extends('layouts')` / `@section('content')`), same as today.

---

### Task 1: Real authentication (replace hardcoded credentials)

**Files:**
- Modify: `phpunit.xml:25-26`
- Modify: `app/Http/Controllers/AuthController.php`
- Modify: `app/Http/Middleware/LoginMiddleware.php`
- Modify: `app/Http/Middleware/RedirectIfAuthenticated.php`
- Modify: `routes/web.php:22-24`
- Modify: `database/seeders/DatabaseSeeder.php`
- Create: `database/seeders/AdminUserSeeder.php`
- Modify: `.env` (add `ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD`)
- Modify: `resources/views/admin/loginAdmin.blade.php`
- Create: `tests/Feature/Admin/AuthTest.php`

**Interfaces:**
- Produces: `Auth::attempt(['email' => ..., 'password' => ...])` as the auth mechanism every later task's middleware/tests rely on (`auth()->check()`, `$this->actingAs($user)`).
- Produces: login form field names `email` + `password` (previously `username` + `password`) — Task 2's layout topbar reads `auth()->user()->name`.

- [ ] **Step 1: Stop tests from touching the dev database**

Edit `phpunit.xml` — uncomment the SQLite in-memory lines so Feature tests never run against `database/database.sqlite`:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

- [ ] **Step 2: Write the failing auth tests**

Create `tests/Feature/Admin/AuthTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'correct-password',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'correct-password',
        ]);

        $response->assertRedirect(route('departments.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'correct-password',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_guest_is_redirected_from_admin_routes(): void
    {
        $response = $this->get('/admin/departments');

        $response->assertRedirect(route('auth.showLogin'));
    }

    public function test_authenticated_admin_is_redirected_away_from_login_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertRedirect(route('departments.index'));
    }

    public function test_login_is_rate_limited_after_five_attempts(): void
    {
        User::factory()->create(['email' => 'admin@example.com', 'password' => 'correct-password']);

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'admin@example.com', 'password' => 'wrong']);
        }

        $response = $this->post('/login', ['email' => 'admin@example.com', 'password' => 'wrong']);

        $response->assertStatus(429);
    }

    public function test_logout_clears_authentication(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    }
}
```

- [ ] **Step 3: Run tests to verify they fail**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/AuthTest.php`
Expected: FAIL — `/login` still expects `username`, rate limiting doesn't exist yet, `/admin/departments` redirect works already (that part may pass).

- [ ] **Step 4: Rewrite AuthController to use Laravel's Auth facade**

Replace `app/Http/Controllers/AuthController.php` entirely:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('admin.loginAdmin');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['login' => 'Invalid credentials'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('departments.index')
            ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.showLogin')
            ->with('success', 'You have been logged out successfully.');
    }
}
```

- [ ] **Step 5: Switch the middleware to Auth::check()**

Replace `app/Http/Middleware/LoginMiddleware.php`:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('auth.showLogin');
        }
        return $next($request);
    }
}
```

Replace `app/Http/Middleware/RedirectIfAuthenticated.php`:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return redirect()->route('departments.index');
        }
        return $next($request);
    }
}
```

- [ ] **Step 6: Add rate limiting to the login route**

In `routes/web.php`, find:

```php
Route::middleware(['guest'])->group(function () {
    Route::get('/admin', [AuthController::class, 'showLogin'])->name('auth.showLogin');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});
```

Replace with:

```php
Route::middleware(['guest'])->group(function () {
    Route::get('/admin', [AuthController::class, 'showLogin'])->name('auth.showLogin');
    Route::post('/login', [AuthController::class, 'login'])
        ->name('auth.login')
        ->middleware('throttle:5,1');
});
```

- [ ] **Step 7: Run tests to verify they pass**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/AuthTest.php`
Expected: PASS (all 6 tests).

- [ ] **Step 8: Seed one real admin user instead of a hardcoded array**

Create `database/seeders/AdminUserSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@sretelu.test')],
            [
                'name' => env('ADMIN_NAME', 'SRE Admin'),
                'password' => env('ADMIN_PASSWORD', 'change-me-now'),
            ]
        );
    }
}
```

`User::$casts` already has `'password' => 'hashed'` (see `app/Models/User.php:41-47`), so Laravel hashes the plain value automatically — don't call `Hash::make()` yourself here.

Edit `database/seeders/DatabaseSeeder.php` — replace the generic factory call with the real seeder:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
    }
}
```

Add to `.env` (pick your own real values, don't commit this file):

```
ADMIN_NAME="SRE Admin"
ADMIN_EMAIL=your-real-admin-email@example.com
ADMIN_PASSWORD=pick-a-strong-password-here
```

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan db:seed --class=AdminUserSeeder`
Expected: one row in `users` with your chosen email and a bcrypt hash in `password`.

- [ ] **Step 9: Restyle the login page and switch its field from username to email**

Replace `resources/views/admin/loginAdmin.blade.php` entirely:

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | SRE Telkom University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;600;700&family=Onest:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Onest', sans-serif; }
        .font-redhat { font-family: 'Red Hat Display', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#104334] flex items-center justify-center px-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl">
        <div class="mb-6 flex justify-center">
            <img src="{{ asset('images/logo2.png') }}" alt="SRE Logo" class="h-16">
        </div>
        <h1 class="mb-6 text-center font-redhat text-xl font-semibold text-[#104334]">Admin Dashboard</h1>

        @if ($errors->has('login'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first('login') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth.login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#104334] {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#104334] {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full rounded-lg bg-[#104334] py-2.5 text-sm font-semibold text-white hover:bg-[#0c3327] transition-colors">
                Login
            </button>
        </form>
    </div>
</body>
</html>
```

- [ ] **Step 10: Manually verify login end-to-end**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan serve --port=8000` (background), then:
```bash
curl -s -c /tmp/cookies.txt http://127.0.0.1:8000/admin -o /dev/null
curl -s -b /tmp/cookies.txt -c /tmp/cookies.txt http://127.0.0.1:8000/admin/departments -o /tmp/should-redirect.html -w "%{http_code}\n"
```
Expected: second call returns a redirect (guest still blocked). Then log in through the browser with your seeded `ADMIN_EMAIL`/`ADMIN_PASSWORD` and confirm `/admin/departments` loads.

- [ ] **Step 11: Commit**

```bash
git add phpunit.xml app/Http/Controllers/AuthController.php app/Http/Middleware/LoginMiddleware.php app/Http/Middleware/RedirectIfAuthenticated.php routes/web.php database/seeders/AdminUserSeeder.php database/seeders/DatabaseSeeder.php resources/views/admin/loginAdmin.blade.php tests/Feature/Admin/AuthTest.php
git commit -m "feat(admin): replace hardcoded login with real Auth-backed authentication"
```

---

### Task 2: Admin design shell (layout, sidebar, flash messages) + remove dead mockup

**Files:**
- Modify: `resources/views/layouts.blade.php`
- Create: `resources/views/partials/admin/sidebar.blade.php`
- Create: `resources/views/partials/admin/flash.blade.php`
- Delete: `resources/views/admin/crudAdmin.blade.php`
- Create: `tests/Feature/Admin/LayoutTest.php`

**Interfaces:**
- Consumes: `Auth::check()` / `auth()->user()->name` from Task 1.
- Produces: every admin view still does `@extends('layouts')` + `@section('content')` — unchanged contract, only what's inside `layouts.blade.php` changes. `partials.admin.flash` renders `session('success')` / `session('error')`, already set by every controller's redirect (e.g. `DepartmentController.php:51`).

- [ ] **Step 1: Write the failing layout test**

Create `tests/Feature/Admin/LayoutTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_render_sidebar_with_all_resource_links(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('departments.index'));

        $response->assertStatus(200);
        $response->assertSee(route('departments.index'), false);
        $response->assertSee(route('members.index'), false);
        $response->assertSee(route('categories.index'), false);
        $response->assertSee(route('programs.index'), false);
        $response->assertSee(route('works.index'), false);
        $response->assertSee(route('alumni.index'), false);
    }

    public function test_success_flash_message_is_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['success' => 'Test flash message'])
            ->get(route('departments.index'));

        $response->assertSee('Test flash message');
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/LayoutTest.php`
Expected: FAIL — current layout has no sidebar links to real routes, no flash partial.

- [ ] **Step 3: Delete the dead admin mockup**

```bash
rm resources/views/admin/crudAdmin.blade.php
```

(It was never referenced by any controller or route — verified via `grep -rn "crudAdmin" app routes` returning nothing.)

- [ ] **Step 4: Create the sidebar partial**

Create `resources/views/partials/admin/sidebar.blade.php`:

```php
<div id="admin-sidebar-overlay" class="fixed inset-0 z-30 hidden bg-black/40 md:hidden"></div>
<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full transform bg-[#104334] px-6 py-8 transition-transform duration-200 md:translate-x-0">
    <div class="mb-10 flex items-center">
        <img src="{{ asset('images/logo2.png') }}" alt="SRE Logo" class="h-14">
    </div>
    <nav class="space-y-1 font-redhat text-sm font-medium">
        @php
            $adminNavLinks = [
                ['route' => 'departments.index', 'prefix' => 'departments.', 'label' => 'Departments', 'icon' => 'fa-building'],
                ['route' => 'members.index', 'prefix' => 'members.', 'label' => 'Members', 'icon' => 'fa-users'],
                ['route' => 'categories.index', 'prefix' => 'categories.', 'label' => 'Categories', 'icon' => 'fa-tags'],
                ['route' => 'programs.index', 'prefix' => 'programs.', 'label' => 'Programs', 'icon' => 'fa-folder-open'],
                ['route' => 'works.index', 'prefix' => 'works.', 'label' => 'Works', 'icon' => 'fa-suitcase'],
                ['route' => 'alumni.index', 'prefix' => 'alumni.', 'label' => 'Alumni', 'icon' => 'fa-user-graduate'],
            ];
        @endphp
        @foreach($adminNavLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs($link['prefix'].'*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                <i class="fas {{ $link['icon'] }} w-4"></i>
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>
</aside>
```

- [ ] **Step 5: Create the flash message partial**

Create `resources/views/partials/admin/flash.blade.php`:

```php
@if(session('success'))
    <div class="mb-4 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        {{ session('success') }}
        <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">&times;</button>
    </div>
@endif
@if(session('error'))
    <div class="mb-4 flex items-center justify-between rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        {{ session('error') }}
        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">&times;</button>
    </div>
@endif
```

- [ ] **Step 6: Rewrite the shared admin layout**

Replace `resources/views/layouts.blade.php` entirely:

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRE Admin | SRE Telkom University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;600;700&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Onest', sans-serif; }
        .font-redhat { font-family: 'Red Hat Display', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gray-100 flex">
    @include('partials.admin.sidebar')

    <div class="flex-1 flex flex-col min-h-screen md:ml-64">
        <header class="sticky top-0 z-20 flex items-center justify-between bg-white border-b border-gray-200 px-4 md:px-8 py-3">
            <button id="admin-sidebar-toggle" type="button" class="md:hidden text-gray-700 text-xl">
                <i class="fas fa-bars"></i>
            </button>
            <div class="hidden md:block"></div>
            <div class="flex items-center gap-4 text-sm text-gray-700">
                <span class="flex items-center gap-2">
                    <i class="fas fa-user-circle text-lg"></i>
                    {{ auth()->user()->name ?? 'Admin' }}
                </span>
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Logout</button>
                </form>
            </div>
        </header>

        <main class="flex-1 p-4 md:p-8">
            @include('partials.admin.flash')
            @yield('content')
        </main>
    </div>

    <script>
        const toggle = document.getElementById('admin-sidebar-toggle');
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('admin-sidebar-overlay');
        toggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });
        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>
</html>
```

- [ ] **Step 7: Run tests to verify they pass**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/LayoutTest.php`
Expected: PASS (both tests). Note: this exercises `departments.index`, which still renders its own Bootstrap `<table>` inside `@section('content')` until Task 3 — that's fine, only the shell around it is under test here.

- [ ] **Step 8: Commit**

```bash
git add resources/views/layouts.blade.php resources/views/partials/admin/sidebar.blade.php resources/views/partials/admin/flash.blade.php tests/Feature/Admin/LayoutTest.php
git rm resources/views/admin/crudAdmin.blade.php
git commit -m "feat(admin): add Tailwind admin shell (sidebar, topbar, flash), remove dead mockup"
```

---

### Task 3: Departments admin views + shared form components

**Files:**
- Create: `resources/views/components/admin/page-header.blade.php`
- Create: `resources/views/components/admin/input.blade.php`
- Create: `resources/views/components/admin/textarea.blade.php`
- Create: `resources/views/components/admin/select.blade.php`
- Create: `resources/views/components/admin/file-input.blade.php`
- Create: `resources/views/components/admin/form-actions.blade.php`
- Create: `resources/views/components/admin/delete-form.blade.php`
- Create: `resources/views/components/admin/icon-link.blade.php`
- Modify: `resources/views/departments/index.blade.php`
- Modify: `resources/views/departments/create.blade.php`
- Modify: `resources/views/departments/edit.blade.php`
- Modify: `resources/views/departments/show.blade.php`
- Create: `tests/Feature/Admin/DepartmentsAdminTest.php`

**Interfaces:**
- Produces (used by every later resource task): `<x-admin.page-header title="" icon="fa-...">…slot for actions…</x-admin.page-header>`, `<x-admin.input name="" label="" type="text" :value="" :required="true">`, `<x-admin.textarea name="" label="" :value="" :required="true">`, `<x-admin.select name="" label="" :options="$collection->pluck('name','id')" :selected="" :required="true">`, `<x-admin.file-input name="" label="" :required="true" hint="">`, `<x-admin.form-actions :back-route="route('x.index')" submit-label="Save">`, `<x-admin.delete-form :action="route('x.destroy', $model)" confirm="Are you sure?">`, `<x-admin.icon-link :href="route('x.show', $model)" icon="fa-eye" variant="info">`.

- [ ] **Step 1: Write the failing Departments admin test**

Create `tests/Feature/Admin/DepartmentsAdminTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DepartmentsAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
    }

    private function makeDepartment(array $overrides = []): Department
    {
        return Department::create(array_merge([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Builds the org website',
            'image' => 'departments/images/placeholder.jpg',
            'logo' => 'departments/logos/placeholder.jpg',
        ], $overrides));
    }

    public function test_index_lists_departments(): void
    {
        $this->makeDepartment();

        $response = $this->actingAs($this->admin)->get(route('departments.index'));

        $response->assertStatus(200)->assertSee('Web Development');
    }

    public function test_create_form_renders_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('departments.create'));

        $response->assertStatus(200)
            ->assertSee('name="name"', false)
            ->assertSee('name="description"', false)
            ->assertSee('name="image"', false)
            ->assertSee('name="logo"', false);
    }

    public function test_store_creates_department(): void
    {
        $response = $this->actingAs($this->admin)->post(route('departments.store'), [
            'name' => 'Data Science',
            'description' => 'Data-focused department',
            'image' => UploadedFile::fake()->image('bg.jpg'),
            'logo' => UploadedFile::fake()->image('logo.jpg'),
        ]);

        $response->assertRedirect(route('departments.index'));
        $this->assertDatabaseHas('departments', ['name' => 'Data Science']);
    }

    public function test_edit_form_prefills_existing_values(): void
    {
        $department = $this->makeDepartment(['name' => 'Cyber Security', 'slug' => 'cyber-security']);

        $response = $this->actingAs($this->admin)->get(route('departments.edit', $department));

        $response->assertStatus(200)->assertSee('value="Cyber Security"', false);
    }

    public function test_show_displays_department_details(): void
    {
        $department = $this->makeDepartment(['name' => 'Networking', 'slug' => 'networking']);

        $response = $this->actingAs($this->admin)->get(route('departments.show', $department));

        $response->assertStatus(200)->assertSee('Networking');
    }

    public function test_destroy_deletes_department_without_members(): void
    {
        $department = $this->makeDepartment(['name' => 'Old Dept', 'slug' => 'old-dept']);

        $response = $this->actingAs($this->admin)->delete(route('departments.destroy', $department));

        $response->assertRedirect(route('departments.index'));
        $this->assertDatabaseMissing('departments', ['id' => $department->id]);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/DepartmentsAdminTest.php`
Expected: FAIL on the two `assertSee` calls looking for `value="..."` (Bootstrap markup is present but differs) — actually most will PASS already since form field names aren't changing. This is a regression guard: keep it green through the rewrite below.

- [ ] **Step 3: Create the shared admin form/table components**

Create `resources/views/components/admin/page-header.blade.php`:

```php
@props(['title', 'icon' => null])
<div class="flex items-center justify-between bg-white rounded-t-xl border border-b-0 border-gray-200 px-6 py-4">
    <h1 class="flex items-center gap-2 text-lg font-semibold text-[#104334] font-redhat">
        @if($icon)
            <i class="fas {{ $icon }}"></i>
        @endif
        {{ $title }}
    </h1>
    <div class="flex items-center gap-2">
        {{ $slot }}
    </div>
</div>
```

Create `resources/views/components/admin/input.blade.php`:

```php
@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#104334] ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
    >
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
```

Create `resources/views/components/admin/textarea.blade.php`:

```php
@props(['name', 'label', 'value' => null, 'required' => false, 'rows' => 4])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#104334] ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
```

Create `resources/views/components/admin/select.blade.php`:

```php
@props(['name', 'label', 'options', 'selected' => null, 'required' => false, 'placeholder' => 'Select an option'])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#104334] ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected(old($name, $selected) == $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
```

Create `resources/views/components/admin/file-input.blade.php`:

```php
@props(['name', 'label', 'required' => false, 'hint' => null])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    <input
        type="file"
        id="{{ $name }}"
        name="{{ $name }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-[#104334] file:px-3 file:py-1.5 file:text-white file:text-sm ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
    >
    @if($hint)
        <p class="mt-1 text-xs text-gray-500">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
```

Create `resources/views/components/admin/form-actions.blade.php`:

```php
@props(['backRoute', 'submitLabel'])
<div class="flex items-center justify-between border-t border-gray-200 pt-4 mt-2">
    <a href="{{ $backRoute }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
        <i class="fas fa-arrow-left"></i> Back
    </a>
    <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
        <i class="fas fa-save"></i> {{ $submitLabel }}
    </button>
</div>
```

Create `resources/views/components/admin/delete-form.blade.php`:

```php
@props(['action', 'confirm' => 'Are you sure?'])
<form action="{{ $action }}" method="POST" onsubmit="return confirm('{{ $confirm }}');">
    @csrf
    @method('DELETE')
    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-red-600 hover:bg-red-50" title="Delete">
        <i class="fas fa-trash"></i>
    </button>
</form>
```

Create `resources/views/components/admin/icon-link.blade.php`:

```php
@props(['href', 'icon', 'variant' => 'info'])
@php
$variants = [
    'info' => 'text-blue-600 hover:bg-blue-50',
    'warning' => 'text-amber-600 hover:bg-amber-50',
];
@endphp
<a href="{{ $href }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md {{ $variants[$variant] }}" title="{{ ucfirst($variant) }}">
    <i class="fas {{ $icon }}"></i>
</a>
```

- [ ] **Step 4: Rewrite the Departments views**

Replace `resources/views/departments/index.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Departments" icon="fa-building">
            <a href="{{ route('departments.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Department
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($departments->isEmpty())
                <p class="text-sm text-gray-500">No departments found. Click "Create New Department" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Members</th>
                                <th class="px-4 py-3">Works</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($departments as $department)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ Storage::url($department->image) }}" alt="{{ $department->name }}" class="h-14 w-14 rounded object-cover">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $department->name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700">{{ $department->members_count }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700">{{ $department->works_count }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $department->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('departments.show', $department)" icon="fa-eye" variant="info" />
                                            <x-admin.icon-link :href="route('departments.edit', $department)" icon="fa-edit" variant="warning" />
                                            <x-admin.delete-form :action="route('departments.destroy', $department)" confirm="Are you sure you want to delete this department?" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $departments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
```

Replace `resources/views/departments/create.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Department" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-admin.input name="name" label="Name" :required="true" />
                <x-admin.input name="description" label="Description" :required="true" />
                <x-admin.file-input name="image" label="Background Image" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.file-input name="logo" label="Logo" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.form-actions :back-route="route('departments.index')" submit-label="Create Department" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/departments/edit.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Department" icon="fa-edit" />
        <div class="px-6 py-6">
            <div class="mb-6 flex gap-6">
                <div class="text-center">
                    <img src="{{ Storage::url($department->image) }}" alt="{{ $department->name }}" class="h-32 w-32 rounded object-cover">
                    <p class="mt-1 text-xs text-gray-500">Current image</p>
                </div>
                @if($department->logo)
                    <div class="text-center">
                        <img src="{{ Storage::url($department->logo) }}" alt="Logo of {{ $department->name }}" class="h-32 w-32 rounded object-contain bg-gray-50">
                        <p class="mt-1 text-xs text-gray-500">Current logo</p>
                    </div>
                @endif
            </div>
            <form action="{{ route('departments.update', $department) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-admin.input name="name" label="Name" :value="$department->name" :required="true" />
                <x-admin.input name="description" label="Description" :value="$department->description" :required="true" />
                <x-admin.file-input name="image" label="Background Image" hint="Leave empty to keep current image." />
                <x-admin.file-input name="logo" label="Logo" hint="Leave empty to keep current logo." />
                <x-admin.form-actions :back-route="route('departments.index')" submit-label="Update Department" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/departments/show.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Department Details" icon="fa-building">
            <x-admin.icon-link :href="route('departments.edit', $department)" icon="fa-edit" variant="warning" />
            <a href="{{ route('departments.index') }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-admin.page-header>

        <div class="px-6 py-6">
            <div class="mb-6 text-center">
                <h2 class="font-redhat text-xl font-semibold text-gray-800">{{ $department->name }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $department->description }}</p>
            </div>

            <div class="mb-6 flex justify-center gap-6">
                @if($department->logo)
                    <img src="{{ Storage::url($department->logo) }}" class="h-32 w-32 rounded object-contain bg-gray-50 p-2" alt="Logo of {{ $department->name }}">
                @endif
                @if($department->image)
                    <img src="{{ Storage::url($department->image) }}" class="h-48 w-64 rounded object-cover" alt="Image of {{ $department->name }}">
                @endif
            </div>

            <p class="mb-6 text-xs text-gray-400">
                Created {{ $department->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} ·
                Updated {{ $department->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}
            </p>

            <h3 class="mb-3 font-redhat text-sm font-semibold text-gray-700">Members ({{ $department->members->count() }})</h3>
            @if($department->members->isEmpty())
                <p class="mb-6 text-sm text-gray-500">No members in this department yet.</p>
            @else
                <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                    @foreach($department->members as $member)
                        <div class="rounded-lg border border-gray-200 p-3">
                            <img src="{{ Storage::url($member->image) }}" class="mb-2 h-32 w-full rounded object-cover" alt="{{ $member->name }}">
                            <p class="font-medium text-gray-800">{{ $member->name }}</p>
                            <p class="text-xs text-gray-500">{{ $member->role }}</p>
                            <a href="{{ route('members.show', $member) }}" class="mt-2 inline-block text-xs font-medium text-blue-600 hover:underline">View</a>
                        </div>
                    @endforeach
                </div>
            @endif

            <h3 class="mb-3 font-redhat text-sm font-semibold text-gray-700">Works ({{ $department->works->count() }})</h3>
            @if($department->works->isEmpty())
                <p class="mb-2 text-sm text-gray-500">No works in this department yet.</p>
            @else
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    @foreach($department->works as $work)
                        <div class="rounded-lg border border-gray-200 p-3">
                            <img src="{{ Storage::url($work->image) }}" class="mb-2 h-32 w-full rounded object-cover" alt="{{ $work->name }}">
                            <p class="font-medium text-gray-800">{{ $work->name }}</p>
                            <p class="text-xs text-gray-500">{{ $work->description }}</p>
                            <a href="{{ route('works.show', $work) }}" class="mt-2 inline-block text-xs font-medium text-blue-600 hover:underline">View</a>
                        </div>
                    @endforeach
                </div>
            @endif

            <x-admin.delete-form :action="route('departments.destroy', $department)" confirm="Are you sure you want to delete this department?" class="mt-6" />
        </div>
    </div>
@endsection
```

- [ ] **Step 5: Run tests to verify they pass**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/DepartmentsAdminTest.php tests/Feature/Admin/LayoutTest.php`
Expected: PASS (all tests, including the sidebar/flash checks from Task 2 since Departments index is what they exercise).

- [ ] **Step 6: Commit**

```bash
git add resources/views/components/admin resources/views/departments tests/Feature/Admin/DepartmentsAdminTest.php
git commit -m "feat(admin): redesign Departments admin views with shared Tailwind components"
```

---

### Task 4: Members admin views

**Files:**
- Modify: `resources/views/members/index.blade.php`
- Modify: `resources/views/members/create.blade.php`
- Modify: `resources/views/members/edit.blade.php`
- Modify: `resources/views/members/show.blade.php`
- Create: `tests/Feature/Admin/MembersAdminTest.php`

**Interfaces:**
- Consumes: `<x-admin.*>` components from Task 3 (no new components needed — Members' fields are name/role/department_id/image, all covered).

- [ ] **Step 1: Write the failing Members admin test**

Create `tests/Feature/Admin/MembersAdminTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\Department;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MembersAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Department $department;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
        $this->department = Department::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Builds the org website',
            'image' => 'departments/images/placeholder.jpg',
            'logo' => 'departments/logos/placeholder.jpg',
        ]);
    }

    public function test_index_lists_members(): void
    {
        Member::create([
            'name' => 'Jane Doe',
            'role' => 'Frontend Engineer',
            'image' => 'members/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('members.index'));

        $response->assertStatus(200)->assertSee('Jane Doe');
    }

    public function test_create_form_renders_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('members.create'));

        $response->assertStatus(200)
            ->assertSee('name="name"', false)
            ->assertSee('name="role"', false)
            ->assertSee('name="department_id"', false)
            ->assertSee('name="image"', false)
            ->assertSee($this->department->name);
    }

    public function test_store_creates_member(): void
    {
        $response = $this->actingAs($this->admin)->post(route('members.store'), [
            'name' => 'John Smith',
            'role' => 'Backend Engineer',
            'department_id' => $this->department->id,
            'image' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', ['name' => 'John Smith']);
    }

    public function test_edit_form_prefills_existing_values(): void
    {
        $member = Member::create([
            'name' => 'Amy Lee',
            'role' => 'Designer',
            'image' => 'members/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('members.edit', $member));

        $response->assertStatus(200)->assertSee('value="Amy Lee"', false);
    }

    public function test_show_displays_member_details(): void
    {
        $member = Member::create([
            'name' => 'Chris Tan',
            'role' => 'QA Engineer',
            'image' => 'members/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('members.show', $member));

        $response->assertStatus(200)->assertSee('Chris Tan');
    }

    public function test_destroy_deletes_member(): void
    {
        $member = Member::create([
            'name' => 'Old Member',
            'role' => 'Alumnus Role',
            'image' => 'members/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('members.destroy', $member));

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }
}
```

- [ ] **Step 2: Run test to verify current state**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/MembersAdminTest.php`
Expected: Mostly PASS already (Bootstrap markup uses the same field names) — this is the regression guard for the rewrite below.

- [ ] **Step 3: Rewrite the Members views**

Replace `resources/views/members/index.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Members" icon="fa-users">
            <a href="{{ route('members.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Member
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($members->isEmpty())
                <p class="text-sm text-gray-500">No members found. Click "Create New Member" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Department</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($members as $member)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ Storage::url($member->image) }}" alt="{{ $member->name }}" class="h-14 w-14 rounded object-cover">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $member->name }}</td>
                                    <td class="px-4 py-3">{{ $member->role }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('departments.show', $member->department) }}" class="text-blue-600 hover:underline">
                                            {{ $member->department->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $member->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('members.show', $member)" icon="fa-eye" variant="info" />
                                            <x-admin.icon-link :href="route('members.edit', $member)" icon="fa-edit" variant="warning" />
                                            <x-admin.delete-form :action="route('members.destroy', $member)" confirm="Are you sure you want to delete this member?" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $members->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
```

Replace `resources/views/members/create.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Member" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-admin.input name="name" label="Name" :required="true" />
                <x-admin.input name="role" label="Role" :required="true" />
                <x-admin.select name="department_id" label="Department" :options="$departments->pluck('name', 'id')" :required="true" placeholder="Select Department" />
                <x-admin.file-input name="image" label="Profile Image" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.form-actions :back-route="route('members.index')" submit-label="Create Member" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/members/edit.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Member" icon="fa-edit" />
        <div class="px-6 py-6">
            <div class="mb-6 text-center">
                <img src="{{ Storage::url($member->image) }}" alt="{{ $member->name }}" class="mx-auto h-32 w-32 rounded object-cover">
                <p class="mt-1 text-xs text-gray-500">Current image</p>
            </div>
            <form action="{{ route('members.update', $member) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-admin.input name="name" label="Name" :value="$member->name" :required="true" />
                <x-admin.input name="role" label="Role" :value="$member->role" :required="true" />
                <x-admin.select name="department_id" label="Department" :options="$departments->pluck('name', 'id')" :selected="$member->department_id" :required="true" placeholder="Select Department" />
                <x-admin.file-input name="image" label="Profile Image" hint="Leave empty to keep current image." />
                <x-admin.form-actions :back-route="route('members.index')" submit-label="Update Member" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/members/show.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Member Details" icon="fa-user">
            <x-admin.icon-link :href="route('members.edit', $member)" icon="fa-edit" variant="warning" />
            <a href="{{ route('members.index') }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-admin.page-header>

        <div class="px-6 py-6">
            <div class="flex gap-6">
                <img src="{{ Storage::url($member->image) }}" alt="{{ $member->name }}" class="h-48 w-48 rounded object-cover">
                <div>
                    <h2 class="font-redhat text-xl font-semibold text-gray-800">{{ $member->name }}</h2>
                    <p class="mt-1 text-sm text-gray-600">Role: {{ $member->role }}</p>
                    <p class="mt-1 text-sm text-gray-600">
                        Department:
                        <a href="{{ route('departments.show', $member->department) }}" class="text-blue-600 hover:underline">{{ $member->department->name }}</a>
                    </p>
                    <p class="mt-3 text-xs text-gray-400">
                        Created {{ $member->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} ·
                        Updated {{ $member->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}
                    </p>
                    <div class="mt-4">
                        <x-admin.delete-form :action="route('members.destroy', $member)" confirm="Are you sure you want to delete this member?" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/MembersAdminTest.php`
Expected: PASS (all 6 tests).

- [ ] **Step 5: Commit**

```bash
git add resources/views/members tests/Feature/Admin/MembersAdminTest.php
git commit -m "feat(admin): redesign Members admin views with shared Tailwind components"
```

---

### Task 5: Categories admin views

**Files:**
- Modify: `resources/views/categories/index.blade.php`
- Modify: `resources/views/categories/create.blade.php`
- Modify: `resources/views/categories/edit.blade.php`
- Modify: `resources/views/categories/show.blade.php`
- Create: `tests/Feature/Admin/CategoriesAdminTest.php`

**Interfaces:**
- Consumes: `<x-admin.*>` components from Task 3 (Categories only need `name`, no file inputs).

- [ ] **Step 1: Write the failing Categories admin test**

Create `tests/Feature/Admin/CategoriesAdminTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_index_lists_categories(): void
    {
        Category::create(['name' => 'Activity']);

        $response = $this->actingAs($this->admin)->get(route('categories.index'));

        $response->assertStatus(200)->assertSee('Activity');
    }

    public function test_create_form_renders_required_field(): void
    {
        $response = $this->actingAs($this->admin)->get(route('categories.create'));

        $response->assertStatus(200)->assertSee('name="name"', false);
    }

    public function test_store_creates_category(): void
    {
        $response = $this->actingAs($this->admin)->post(route('categories.store'), [
            'name' => 'Research',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Research']);
    }

    public function test_edit_form_prefills_existing_value(): void
    {
        $category = Category::create(['name' => 'Competition']);

        $response = $this->actingAs($this->admin)->get(route('categories.edit', $category));

        $response->assertStatus(200)->assertSee('value="Competition"', false);
    }

    public function test_show_displays_category_details(): void
    {
        $category = Category::create(['name' => 'Workshop']);

        $response = $this->actingAs($this->admin)->get(route('categories.show', $category));

        $response->assertStatus(200)->assertSee('Workshop');
    }

    public function test_destroy_deletes_category(): void
    {
        $category = Category::create(['name' => 'Old Category']);

        $response = $this->actingAs($this->admin)->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
```

- [ ] **Step 2: Run test to verify current state**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/CategoriesAdminTest.php`
Expected: mostly PASS already — regression guard for the rewrite below.

- [ ] **Step 3: Rewrite the Categories views**

Replace `resources/views/categories/index.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Categories" icon="fa-tags">
            <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Category
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($categories->isEmpty())
                <p class="text-sm text-gray-500">No categories found. Click "Create New Category" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($categories as $category)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $category->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('categories.show', $category)" icon="fa-eye" variant="info" />
                                            <x-admin.icon-link :href="route('categories.edit', $category)" icon="fa-edit" variant="warning" />
                                            <x-admin.delete-form :action="route('categories.destroy', $category)" confirm="Are you sure you want to delete this category?" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
```

Replace `resources/views/categories/create.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Category" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <x-admin.input name="name" label="Category Name" :required="true" />
                <x-admin.form-actions :back-route="route('categories.index')" submit-label="Create Category" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/categories/edit.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Category" icon="fa-edit" />
        <div class="px-6 py-6">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <x-admin.input name="name" label="Category Name" :value="$category->name" :required="true" />
                <x-admin.form-actions :back-route="route('categories.index')" submit-label="Update Category" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/categories/show.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Category Details" icon="fa-tag">
            <x-admin.icon-link :href="route('categories.edit', $category)" icon="fa-edit" variant="warning" />
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-admin.page-header>
        <div class="px-6 py-6">
            <h2 class="font-redhat text-xl font-semibold text-gray-800">{{ $category->name }}</h2>
            <p class="mt-3 text-xs text-gray-400">
                Created {{ $category->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} ·
                Updated {{ $category->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}
            </p>
        </div>
    </div>
@endsection
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/CategoriesAdminTest.php`
Expected: PASS (all 6 tests).

- [ ] **Step 5: Commit**

```bash
git add resources/views/categories tests/Feature/Admin/CategoriesAdminTest.php
git commit -m "feat(admin): redesign Categories admin views with shared Tailwind components"
```

---

### Task 6: Programs admin views (+ fix missing pagination controls)

**Files:**
- Modify: `resources/views/programs/index.blade.php`
- Modify: `resources/views/programs/create.blade.php`
- Modify: `resources/views/programs/edit.blade.php`
- Modify: `resources/views/programs/show.blade.php`
- Create: `tests/Feature/Admin/ProgramsAdminTest.php`

**Interfaces:**
- Consumes: `<x-admin.*>` components from Task 3.
- Note: `ProgramsController::index` already does `Programs::with('category')->oldest()->paginate(10)` (`app/Http/Controllers/ProgramsController.php:21`), but the current view never calls `$programs->links()` — this task fixes that pre-existing bug as part of the rewrite.

- [ ] **Step 1: Write the failing Programs admin test**

Create `tests/Feature/Admin/ProgramsAdminTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Programs;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProgramsAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
        $this->category = Category::create(['name' => 'Activity']);
    }

    public function test_index_lists_programs_with_pagination_links(): void
    {
        Programs::create([
            'title' => 'Coding Bootcamp',
            'slug' => 'coding-bootcamp',
            'desc' => 'A hands-on bootcamp',
            'image' => 'programs/placeholder.jpg',
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('programs.index'));

        $response->assertStatus(200)->assertSee('Coding Bootcamp');
    }

    public function test_create_form_renders_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('programs.create'));

        $response->assertStatus(200)
            ->assertSee('name="title"', false)
            ->assertSee('name="desc"', false)
            ->assertSee('name="category_id"', false)
            ->assertSee('name="image"', false)
            ->assertSee('name="instagram"', false);
    }

    public function test_store_creates_program(): void
    {
        $response = $this->actingAs($this->admin)->post(route('programs.store'), [
            'title' => 'Hackathon 2026',
            'desc' => 'Annual hackathon',
            'category_id' => $this->category->id,
            'image' => UploadedFile::fake()->image('program.jpg'),
            'instagram' => 'https://instagram.com/sre',
        ]);

        $response->assertRedirect(route('programs.index'));
        $this->assertDatabaseHas('programs', ['title' => 'Hackathon 2026']);
    }

    public function test_edit_form_prefills_existing_values(): void
    {
        $program = Programs::create([
            'title' => 'Research Sprint',
            'slug' => 'research-sprint',
            'desc' => 'A research sprint',
            'image' => 'programs/placeholder.jpg',
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('programs.edit', $program));

        $response->assertStatus(200)->assertSee('value="Research Sprint"', false);
    }

    public function test_show_displays_program_details(): void
    {
        $program = Programs::create([
            'title' => 'Demo Day',
            'slug' => 'demo-day',
            'desc' => 'Showcasing student projects',
            'image' => 'programs/placeholder.jpg',
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('programs.show', $program));

        $response->assertStatus(200)->assertSee('Demo Day');
    }

    public function test_destroy_deletes_program(): void
    {
        $program = Programs::create([
            'title' => 'Old Program',
            'slug' => 'old-program',
            'desc' => 'Deprecated',
            'image' => 'programs/placeholder.jpg',
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('programs.destroy', $program));

        $response->assertRedirect(route('programs.index'));
        $this->assertDatabaseMissing('programs', ['id' => $program->id]);
    }
}
```

- [ ] **Step 2: Run test to verify current state**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/ProgramsAdminTest.php`
Expected: mostly PASS already — regression guard for the rewrite below.

- [ ] **Step 3: Rewrite the Programs views**

Replace `resources/views/programs/index.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Programs" icon="fa-folder-open">
            <a href="{{ route('programs.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Program
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($programs->isEmpty())
                <p class="text-sm text-gray-500">No programs found. Click "Create New Program" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Instagram</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($programs as $program)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        @if($program->image)
                                            <img src="{{ Storage::url($program->image) }}" alt="{{ $program->title }}" class="h-14 w-14 rounded object-cover">
                                        @else
                                            <span class="text-xs text-gray-400">No image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $program->title }}</td>
                                    <td class="px-4 py-3">{{ $program->category->name ?? '-' }}</td>
                                    <td class="px-4 py-3 max-w-xs truncate">
                                        @if($program->instagram)
                                            <a href="{{ $program->instagram }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">{{ $program->instagram }}</a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $program->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('programs.show', $program)" icon="fa-eye" variant="info" />
                                            <x-admin.icon-link :href="route('programs.edit', $program)" icon="fa-edit" variant="warning" />
                                            <x-admin.delete-form :action="route('programs.destroy', $program)" confirm="Are you sure you want to delete this program?" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $programs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
```

Replace `resources/views/programs/create.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Program" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('programs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-admin.input name="title" label="Program Title" :required="true" />
                <x-admin.textarea name="desc" label="Description" :required="true" />
                <x-admin.file-input name="image" label="Program Image" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.select name="category_id" label="Category" :options="$categories->pluck('name', 'id')" :required="true" placeholder="Select Category" />
                <x-admin.input name="instagram" label="Instagram Link" />
                <x-admin.form-actions :back-route="route('programs.index')" submit-label="Create Program" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/programs/edit.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Program" icon="fa-edit" />
        <div class="px-6 py-6">
            @if($program->image)
                <div class="mb-6 text-center">
                    <img src="{{ Storage::url($program->image) }}" alt="{{ $program->title }}" class="mx-auto h-32 w-32 rounded object-cover">
                    <p class="mt-1 text-xs text-gray-500">Current image</p>
                </div>
            @endif
            <form action="{{ route('programs.update', $program) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-admin.input name="title" label="Program Title" :value="$program->title" :required="true" />
                <x-admin.textarea name="desc" label="Description" :value="$program->desc" :required="true" />
                <x-admin.file-input name="image" label="Program Image" hint="Leave empty to keep current image." />
                <x-admin.select name="category_id" label="Category" :options="$categories->pluck('name', 'id')" :selected="$program->category_id" :required="true" placeholder="Select Category" />
                <x-admin.input name="instagram" label="Instagram Link" :value="$program->instagram" />
                <x-admin.form-actions :back-route="route('programs.index')" submit-label="Update Program" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/programs/show.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Program Details" icon="fa-info-circle">
            <x-admin.icon-link :href="route('programs.edit', $program)" icon="fa-edit" variant="warning" />
            <a href="{{ route('programs.index') }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-admin.page-header>

        <div class="px-6 py-6">
            <div class="flex gap-6">
                @if($program->image)
                    <img src="{{ Storage::url($program->image) }}" alt="{{ $program->title }}" class="h-48 w-48 rounded object-cover">
                @endif
                <div>
                    <h2 class="font-redhat text-xl font-semibold text-gray-800">{{ $program->title }}</h2>
                    <p class="mt-1 text-sm text-gray-600">Category: {{ $program->category->name ?? '-' }}</p>
                    <p class="mt-2 text-sm text-gray-700">{{ $program->desc }}</p>
                    <p class="mt-2 text-sm">
                        Instagram:
                        @if($program->instagram)
                            <a href="{{ $program->instagram }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">{{ $program->instagram }}</a>
                        @else
                            <span class="italic text-gray-400">No Instagram link</span>
                        @endif
                    </p>
                    <p class="mt-3 text-xs text-gray-400">
                        Created {{ $program->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} ·
                        Updated {{ $program->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}
                    </p>
                    <div class="mt-4">
                        <x-admin.delete-form :action="route('programs.destroy', $program)" confirm="Are you sure you want to delete this program?" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/ProgramsAdminTest.php`
Expected: PASS (all 6 tests).

- [ ] **Step 5: Commit**

```bash
git add resources/views/programs tests/Feature/Admin/ProgramsAdminTest.php
git commit -m "feat(admin): redesign Programs admin views, fix missing pagination links"
```

---

### Task 7: Works admin views (+ fix missing pagination controls)

**Files:**
- Modify: `resources/views/works/index.blade.php`
- Modify: `resources/views/works/create.blade.php`
- Modify: `resources/views/works/edit.blade.php`
- Modify: `resources/views/works/show.blade.php`
- Create: `tests/Feature/Admin/WorksAdminTest.php`

**Interfaces:**
- Consumes: `<x-admin.*>` components from Task 3.
- Note: same pre-existing bug as Programs — `WorkController::index` paginates (`app/Http/Controllers/WorkController.php:22`) but the view never calls `$works->links()`. Fixed here.

- [ ] **Step 1: Write the failing Works admin test**

Create `tests/Feature/Admin/WorksAdminTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\Department;
use App\Models\User;
use App\Models\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WorksAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Department $department;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
        $this->department = Department::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Builds the org website',
            'image' => 'departments/images/placeholder.jpg',
            'logo' => 'departments/logos/placeholder.jpg',
        ]);
    }

    public function test_index_lists_works(): void
    {
        Work::create([
            'name' => 'Portfolio Site',
            'description' => 'The org portfolio website',
            'image' => 'works/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('works.index'));

        $response->assertStatus(200)->assertSee('Portfolio Site');
    }

    public function test_create_form_renders_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('works.create'));

        $response->assertStatus(200)
            ->assertSee('name="name"', false)
            ->assertSee('name="description"', false)
            ->assertSee('name="department_id"', false)
            ->assertSee('name="image"', false);
    }

    public function test_store_creates_work(): void
    {
        $response = $this->actingAs($this->admin)->post(route('works.store'), [
            'name' => 'Mobile App',
            'description' => 'The org mobile app',
            'department_id' => $this->department->id,
            'image' => UploadedFile::fake()->image('work.jpg'),
        ]);

        $response->assertRedirect(route('works.index'));
        $this->assertDatabaseHas('works', ['name' => 'Mobile App']);
    }

    public function test_edit_form_prefills_existing_values(): void
    {
        $work = Work::create([
            'name' => 'Internal Tool',
            'description' => 'Internal dashboard',
            'image' => 'works/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('works.edit', $work));

        $response->assertStatus(200)->assertSee('value="Internal Tool"', false);
    }

    public function test_show_displays_work_details(): void
    {
        $work = Work::create([
            'name' => 'API Gateway',
            'description' => 'Central API gateway',
            'image' => 'works/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('works.show', $work));

        $response->assertStatus(200)->assertSee('API Gateway');
    }

    public function test_destroy_deletes_work(): void
    {
        $work = Work::create([
            'name' => 'Old Work',
            'description' => 'Deprecated work',
            'image' => 'works/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('works.destroy', $work));

        $response->assertRedirect(route('works.index'));
        $this->assertDatabaseMissing('works', ['id' => $work->id]);
    }
}
```

- [ ] **Step 2: Run test to verify current state**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/WorksAdminTest.php`
Expected: mostly PASS already — regression guard for the rewrite below.

- [ ] **Step 3: Rewrite the Works views**

Replace `resources/views/works/index.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Works" icon="fa-suitcase">
            <a href="{{ route('works.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Work
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($works->isEmpty())
                <p class="text-sm text-gray-500">No works found. Click "Create New Work" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Department</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($works as $work)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ Storage::url($work->image) }}" alt="{{ $work->name }}" class="h-14 w-14 rounded object-cover">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $work->name }}</td>
                                    <td class="px-4 py-3 max-w-xs truncate">{{ $work->description }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('departments.show', $work->department) }}" class="text-blue-600 hover:underline">{{ $work->department->name }}</a>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $work->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('works.show', $work)" icon="fa-eye" variant="info" />
                                            <x-admin.icon-link :href="route('works.edit', $work)" icon="fa-edit" variant="warning" />
                                            <x-admin.delete-form :action="route('works.destroy', $work)" confirm="Are you sure you want to delete this work?" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $works->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
```

Replace `resources/views/works/create.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Work" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('works.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-admin.input name="name" label="Name" :required="true" />
                <x-admin.input name="description" label="Description" :required="true" />
                <x-admin.select name="department_id" label="Department" :options="$departments->pluck('name', 'id')" :required="true" placeholder="Select Department" />
                <x-admin.file-input name="image" label="Image" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.form-actions :back-route="route('works.index')" submit-label="Create Work" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/works/edit.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Work" icon="fa-edit" />
        <div class="px-6 py-6">
            <div class="mb-6 text-center">
                <img src="{{ Storage::url($work->image) }}" alt="{{ $work->name }}" class="mx-auto h-32 w-32 rounded object-cover">
                <p class="mt-1 text-xs text-gray-500">Current image</p>
            </div>
            <form action="{{ route('works.update', $work) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-admin.input name="name" label="Name" :value="$work->name" :required="true" />
                <x-admin.input name="description" label="Description" :value="$work->description" :required="true" />
                <x-admin.select name="department_id" label="Department" :options="$departments->pluck('name', 'id')" :selected="$work->department_id" :required="true" placeholder="Select Department" />
                <x-admin.file-input name="image" label="Image" hint="Leave empty to keep current image." />
                <x-admin.form-actions :back-route="route('works.index')" submit-label="Update Work" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/works/show.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Work Details" icon="fa-suitcase">
            <x-admin.icon-link :href="route('works.edit', $work)" icon="fa-edit" variant="warning" />
            <a href="{{ route('works.index') }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-admin.page-header>

        <div class="px-6 py-6">
            <div class="flex gap-6">
                <img src="{{ Storage::url($work->image) }}" alt="{{ $work->name }}" class="h-48 w-48 rounded object-cover">
                <div>
                    <h2 class="font-redhat text-xl font-semibold text-gray-800">{{ $work->name }}</h2>
                    <p class="mt-1 text-sm text-gray-700">{{ $work->description }}</p>
                    <p class="mt-1 text-sm text-gray-600">
                        Department:
                        <a href="{{ route('departments.show', $work->department) }}" class="text-blue-600 hover:underline">{{ $work->department->name }}</a>
                    </p>
                    <p class="mt-3 text-xs text-gray-400">
                        Created {{ $work->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} ·
                        Updated {{ $work->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}
                    </p>
                    <div class="mt-4">
                        <x-admin.delete-form :action="route('works.destroy', $work)" confirm="Are you sure you want to delete this work?" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/WorksAdminTest.php`
Expected: PASS (all 6 tests).

- [ ] **Step 5: Commit**

```bash
git add resources/views/works tests/Feature/Admin/WorksAdminTest.php
git commit -m "feat(admin): redesign Works admin views, fix missing pagination links"
```

---

### Task 8: Alumni admin views (+ add pagination)

**Files:**
- Modify: `app/Http/Controllers/AlumniController.php:12-16`
- Modify: `resources/views/alumni/index.blade.php`
- Modify: `resources/views/alumni/create.blade.php`
- Modify: `resources/views/alumni/edit.blade.php`
- Modify: `resources/views/alumni/show.blade.php`
- Create: `tests/Feature/Admin/AlumniAdminTest.php`

**Interfaces:**
- Consumes: `<x-admin.*>` components from Task 3.
- Note: Alumni is the only resource without pagination at all (`Alumni::all()` in `AlumniController::index`) — every other resource paginates at 10. This task brings it in line, since an unbounded `::all()` is exactly the kind of backend inefficiency flagged earlier (it will load every alumni row into memory on every page view as the table grows).

- [ ] **Step 1: Write the failing Alumni admin test**

Create `tests/Feature/Admin/AlumniAdminTest.php`:

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AlumniAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
    }

    public function test_index_lists_alumni(): void
    {
        Alumni::create([
            'name' => 'Alex Wong',
            'achievement' => 'National coding champion',
            'image' => 'alumni/placeholder.jpg',
        ]);

        $response = $this->actingAs($this->admin)->get(route('alumni.index'));

        $response->assertStatus(200)->assertSee('Alex Wong');
    }

    public function test_create_form_renders_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('alumni.create'));

        $response->assertStatus(200)
            ->assertSee('name="name"', false)
            ->assertSee('name="achievement"', false)
            ->assertSee('name="image"', false);
    }

    public function test_store_creates_alumni(): void
    {
        $response = $this->actingAs($this->admin)->post(route('alumni.store'), [
            'name' => 'Bella Putri',
            'achievement' => 'Best thesis award',
            'image' => UploadedFile::fake()->image('alumni.jpg'),
        ]);

        $response->assertRedirect(route('alumni.index'));
        $this->assertDatabaseHas('alumnis', ['name' => 'Bella Putri']);
    }

    public function test_edit_form_prefills_existing_values(): void
    {
        $alumni = Alumni::create([
            'name' => 'Carlos Diaz',
            'achievement' => 'Startup founder',
            'image' => 'alumni/placeholder.jpg',
        ]);

        $response = $this->actingAs($this->admin)->get(route('alumni.edit', $alumni));

        $response->assertStatus(200)->assertSee('value="Carlos Diaz"', false);
    }

    public function test_show_displays_alumni_details(): void
    {
        $alumni = Alumni::create([
            'name' => 'Dina Marlina',
            'achievement' => 'Published researcher',
            'image' => 'alumni/placeholder.jpg',
        ]);

        $response = $this->actingAs($this->admin)->get(route('alumni.show', $alumni));

        $response->assertStatus(200)->assertSee('Dina Marlina');
    }

    public function test_destroy_deletes_alumni(): void
    {
        $alumni = Alumni::create([
            'name' => 'Old Alumni',
            'achievement' => 'N/A',
            'image' => 'alumni/placeholder.jpg',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('alumni.destroy', $alumni));

        $response->assertRedirect(route('alumni.index'));
        $this->assertDatabaseMissing('alumnis', ['id' => $alumni->id]);
    }
}
```

- [ ] **Step 2: Run test to verify current state**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/AlumniAdminTest.php`
Expected: mostly PASS already — regression guard for the rewrite below.

- [ ] **Step 3: Paginate the Alumni index**

In `app/Http/Controllers/AlumniController.php`, replace:

```php
    public function index(): View
    {
        $alumnis = Alumni::all();
        return view('alumni.index', compact('alumnis'));
    }
```

with:

```php
    public function index(): View
    {
        $alumnis = Alumni::oldest()->paginate(10);
        return view('alumni.index', compact('alumnis'));
    }
```

- [ ] **Step 4: Rewrite the Alumni views**

Replace `resources/views/alumni/index.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Alumni" icon="fa-user-graduate">
            <a href="{{ route('alumni.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Alumni
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($alumnis->isEmpty())
                <p class="text-sm text-gray-500">No alumni found. Click "Create New Alumni" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Achievement</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($alumnis as $alumni)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ Storage::url($alumni->image) }}" alt="{{ $alumni->name }}" class="h-14 w-14 rounded object-cover">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $alumni->name }}</td>
                                    <td class="px-4 py-3 max-w-xs truncate">{{ $alumni->achievement }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $alumni->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('alumni.show', $alumni)" icon="fa-eye" variant="info" />
                                            <x-admin.icon-link :href="route('alumni.edit', $alumni)" icon="fa-edit" variant="warning" />
                                            <x-admin.delete-form :action="route('alumni.destroy', $alumni)" confirm="Are you sure you want to delete this alumni?" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $alumnis->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
```

Replace `resources/views/alumni/create.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Alumni" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('alumni.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-admin.input name="name" label="Name" :required="true" />
                <x-admin.input name="achievement" label="Achievement" :required="true" />
                <x-admin.file-input name="image" label="Image" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.form-actions :back-route="route('alumni.index')" submit-label="Create Alumni" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/alumni/edit.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Alumni" icon="fa-edit" />
        <div class="px-6 py-6">
            <div class="mb-6 text-center">
                <img src="{{ Storage::url($alumni->image) }}" alt="{{ $alumni->name }}" class="mx-auto h-32 w-32 rounded object-cover">
                <p class="mt-1 text-xs text-gray-500">Current image</p>
            </div>
            <form action="{{ route('alumni.update', $alumni) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-admin.input name="name" label="Name" :value="$alumni->name" :required="true" />
                <x-admin.input name="achievement" label="Achievement" :value="$alumni->achievement" :required="true" />
                <x-admin.file-input name="image" label="Image" hint="Leave empty to keep current image." />
                <x-admin.form-actions :back-route="route('alumni.index')" submit-label="Update Alumni" />
            </form>
        </div>
    </div>
@endsection
```

Replace `resources/views/alumni/show.blade.php`:

```php
@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Alumni Details" icon="fa-user-graduate">
            <x-admin.icon-link :href="route('alumni.edit', $alumni)" icon="fa-edit" variant="warning" />
            <a href="{{ route('alumni.index') }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-admin.page-header>

        <div class="px-6 py-6">
            <div class="flex gap-6">
                <img src="{{ Storage::url($alumni->image) }}" alt="{{ $alumni->name }}" class="h-48 w-48 rounded object-cover">
                <div>
                    <h2 class="font-redhat text-xl font-semibold text-gray-800">{{ $alumni->name }}</h2>
                    <p class="mt-1 text-sm text-gray-700">{{ $alumni->achievement }}</p>
                    <p class="mt-3 text-xs text-gray-400">
                        Created {{ $alumni->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} ·
                        Updated {{ $alumni->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}
                    </p>
                    <div class="mt-4">
                        <x-admin.delete-form :action="route('alumni.destroy', $alumni)" confirm="Are you sure you want to delete this alumni?" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```

- [ ] **Step 5: Run tests to verify they pass**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test tests/Feature/Admin/AlumniAdminTest.php`
Expected: PASS (all 6 tests).

- [ ] **Step 6: Commit**

```bash
git add app/Http/Controllers/AlumniController.php resources/views/alumni tests/Feature/Admin/AlumniAdminTest.php
git commit -m "feat(admin): redesign Alumni admin views, add missing pagination"
```

---

### Task 9: Full integration pass

**Files:**
- None created/modified — verification only.

**Interfaces:**
- Consumes: everything from Tasks 1–8.

- [ ] **Step 1: Run the full automated test suite**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan test`
Expected: all tests pass, including the pre-existing `tests/Feature/ExampleTest.php` (public homepage) and every new `tests/Feature/Admin/*Test.php`.

- [ ] **Step 2: Rebuild front-end assets**

Run: `npm run build`
Expected: succeeds (no admin views touch the Vite pipeline, but this confirms nothing on the public side broke).

- [ ] **Step 3: Manual click-through on the real dev server**

Run: `/opt/homebrew/opt/php@8.3/bin/php artisan serve --port=8000` (background), then in a browser:
1. Visit `http://127.0.0.1:8000/admin`, confirm the new login page renders and the brand colors/fonts match the public site.
2. Log in with your seeded `ADMIN_EMAIL` / `ADMIN_PASSWORD`.
3. Click through Departments → Members → Categories → Programs → Works → Alumni in the sidebar; confirm the active link highlights correctly and each index/create/edit/show page renders without console errors.
4. Create one record with an image upload in each resource, confirm success flash message and image preview.
5. Log out, confirm redirect to the login page and that `/admin/departments` now redirects back to login.

- [ ] **Step 4: Confirm no leftover references to the old auth session key or dead file**

Run: `grep -rn "session('authenticated')\|crudAdmin" app resources routes`
Expected: no output.

- [ ] **Step 5: Final commit (if anything was left uncommitted)**

```bash
git status
git add -A
git commit -m "chore(admin): final integration pass for admin redesign + real auth"
```
