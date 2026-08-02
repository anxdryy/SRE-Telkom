# Public Site — Frontend Design Audit (Quick Mode)

**Scope:** Public-facing views only — `welcome.blade.php`, `departement.blade.php`, `activity.blade.php`, `research.blade.php`, `competition.blade.php`, `aboutus.blade.php`, `news.blade.php`, and the shared partials `navbar.blade.php`, `othernavbar.blade.php`, `footer.blade.php`, `carousel.blade.php`. Admin panel views were explicitly out of scope and not touched.

**Interface type:** Small student-organization portfolio/marketing site (Laravel 11 + Blade + Tailwind, Vite-compiled).

**Source reviewed:** all files above, plus `app/Http/Controllers/DepartmentController.php`, `AboutUsController.php`, `ProgramsController.php`, `routes/web.php`, `app/Models/Department.php`, `resources/views/vendor/pagination/tailwind.blade.php`, `resources/css/app.css`.

---

## Fixed (severity 3–4, and safe severity 2)

| # | Issue | Severity | File | Principle |
|---|-------|----------|------|-----------|
| 1 | Department logos on the About Us page used `$dept['alt']`, a property that doesn't exist on the `Department` model (only `name`, `description`, `image`, `logo`, `slug` are fillable). Every department logo rendered with an **empty `alt`** attribute. | 4 | `aboutus.blade.php` | Accessibility (H13) |
| 2 | 7 "Core Team" photos (`coreperson.png`) had **no `alt` attribute at all** — completely inaccessible to screen readers. | 4 | `aboutus.blade.php` | Accessibility (H13) |
| 3 | `Activity`/`Research`/`Competition` listing pages had **no empty state**. If a category has zero programs, the page renders a blank gap between the tabs and the pager with zero explanation. Confirmed live: the current dev DB has 0 programs, and before the fix all three pages rendered nothing there. | 3 | `activity.blade.php`, `research.blade.php`, `competition.blade.php` | Recognition Over Recall (H6) |
| 4 | Icon-only "back" link on the program detail page had no accessible name (screen readers announce nothing/"link") and was permanently `animate-bounce`-ing — a distracting, unexplained animation on a static back-navigation control (this animation makes sense on the homepage's "scroll down" cue but not here). | 3 | `news.blade.php` | Accessibility (H13) / Affordances (H11) |
| 5 | Same icon-only back link had a 32×32px touch target, under the 44×44px minimum recommended for touch. | 2 | `news.blade.php` | Affordances & Signifiers (H11) |
| 6 | Decorative images (`innovate.png`, `elevate.png`, `Group 45.png`) had no `alt` at all (should be empty `alt=""` since adjacent visible text already conveys their meaning). | 2 | `aboutus.blade.php` | Accessibility (H13) |
| 7 | No site-wide visible keyboard focus indicator — links/buttons across every public page relied on the browser default outline (some elements even had `focus:outline-none` with nothing to replace it), making keyboard navigation hard to track. | 2–3 | `resources/css/app.css` (site-wide) | Accessibility (H13) / Affordances (H11) |
| 8 | Inconsistent footer spacing between the three near-identical program listing pages: `activity.blade.php` used `mt-32`, `research.blade.php` and `competition.blade.php` used `mt-48` (with a stray comment "Adjust tree height by pushing footer down"). Standardized all three to `mt-32`. | 2 | `activity.blade.php`, `research.blade.php`, `competition.blade.php` | Consistency and Standards (H4) |
| 9 | Category tab labels (`Activity`/`Research`/`Competition` selector) used `text-gray-400` (~2.9:1 contrast on white), failing WCAG even for large text (needs 3:1); same color used for the "Programs" eyebrow label at a size that needs 4.5:1. Bumped to `text-gray-500` (~4.8:1) and added a hover color + `transition-colors` so the inactive tabs also read as clickable. | 2 | `activity.blade.php`, `research.blade.php`, `competition.blade.php` | Accessibility (H13) / Affordances (H11) |
| 10 | Program listing pages had no `<h1>` at all — heading order jumped straight to `h2`/`h3`. Added a visually-hidden (`sr-only`) `<h1>` naming the category, so document structure/screen-reader navigation has a real page title without changing the visual design. | 2 | `activity.blade.php`, `research.blade.php`, `competition.blade.php` | Accessibility / Structure (H12, H13) |
| 11 | `/departement` (list-only route, no `$department` set) had no `<h1>` on the page at all — only an `<h2>`. Added a conditional `sr-only` `<h1>Our Departments</h1>` that only renders when the detail heading isn't already present, so there's never more than one `<h1>`. | 2 | `departement.blade.php` | Accessibility / Structure (H12, H13) |
| 12 | About Us page had heading order reversed: `<h2>About Us</h2>` appeared before `<h1>SRE Telkom University</h1>` in the DOM. Changed the eyebrow label to a `<p>` and kept the page title as the sole `<h1>` — no visual change. | 2 | `aboutus.blade.php` | Accessibility / Structure (H12, H13) |
| 13 | `<style>` blocks were placed **after `</head>` and before `<body>`** (invalid HTML — browsers tolerate it via auto-recovery, but it's non-conforming markup) in three files. Moved inside `<head>`. | 1–2 | `aboutus.blade.php`, `departement.blade.php`, `news.blade.php` | Consistency and Standards (H4) |
| 14 | Every public page shared the identical, generic `<title>SRE Telkom University</title>`, so browser tabs/history/bookmarks couldn't be told apart, and the homepage's own title oddly read "SRE **\|** Telkom University" (as if SRE and Telkom University were two different things). Gave every page a distinct, descriptive title (e.g. "About Us \| SRE Telkom University", "Activity Programs \| SRE Telkom University", program-title-based on the detail page, department-name-based on department pages) and fixed the homepage's pipe placement. | 2 | `welcome.blade.php`, `aboutus.blade.php`, `departement.blade.php`, `activity.blade.php`, `research.blade.php`, `competition.blade.php`, `news.blade.php` | Match Between System and Real World (H2) / Recognition Over Recall |
| 15 | Alumni carousel prev/next buttons only contained a raw `&larr;`/`&rarr;` glyph with no accessible label. Added `aria-label="Previous/Next alumni"` and marked the glyph `aria-hidden`. | 2 | `partials/carousel.blade.php` | Accessibility (H13) |
| 16 | Hamburger menu button and both "Programs" dropdown triggers (desktop + mobile, in both navbar partials) had no `aria-expanded`/`aria-haspopup`/`aria-controls`, so screen reader users got no signal these were expandable menus. Added the attributes and wired the existing toggle JS to keep `aria-expanded` in sync with actual open/closed state (verified `node --check` on the extracted script — no syntax errors introduced). | 2 | `partials/navbar.blade.php`, `partials/othernavbar.blade.php` | Accessibility (H13) |
| 17 | No `prefers-reduced-motion` support anywhere on the site (fade-ins, bounces, autoplaying carousel play at full speed regardless of OS setting). Added a global reduced-motion media query that shortens animations/transitions for users who've opted into it at the OS level, without changing anything for everyone else. | 2 | `resources/css/app.css` (site-wide) | Flexibility & Efficiency (H7) / Perceptibility (H14) |

## Not auto-fixed (report only)

| # | Issue | Severity | Why not auto-fixed |
|---|-------|----------|--------------------|
| 1 | Alumni carousel autoplays every 3.5s indefinitely; only pauses on `mouseenter` (desktop only) — mobile/touch users have no way to pause it. | 2 | Fixing this properly means adding a new visible pause/play control, which is a UI feature addition, not a violation fix — better suited for discussion mode where placement/style can be agreed on. |
| 2 | Department detail page (`/departement/{slug}`) has no "back to all departments" link near the top; the only way back is scrolling to the department grid re-rendered at the bottom of the same page. | 2 | The grid at the bottom does provide a navigation path, so this is a minor wayfinding rough edge, not a dead end. Adding a breadcrumb/back-link is a placement/design decision better made with the user. |
| 3 | The 7 "Core Team" entries on the About Us page are all identical placeholder content ("Fajar Dwitama" / "President SRE" repeated 7 times with the same stock photo). | 2 | This is a content/data issue, not a template bug — the auditor doesn't have the real team roster to fill in, and inventing names would be worse than flagging it. |
| 4 | Pagination links (`vendor/pagination/tailwind.blade.php`) use `px-3 py-2` (~32–36px effective height), below the 44px recommended minimum touch target. | 1–2 | Shared across three pages; resizing risks visual layout shifts in the pager that weren't verified against a live design. Flagging for a deliberate follow-up pass rather than guessing at padding values. |
| 5 | Font `<link>` tags and the same `.font-redhat`/`.font-onest`/`.font-redhattext` CSS declarations are duplicated in a `<style>` block on every single view instead of a shared layout. | 1 | Real inconsistency risk (a typo in one copy silently diverges from the others), but consolidating requires introducing a shared Blade layout/component, which was explicitly out of scope for this pass ("do not create new Blade components," "don't restructure"). |
| 6 | Did not exhaustively contrast-check every gray-on-color text combination site-wide (e.g. footer `text-gray-400 text-xs` copyright line on the dark green background) — spot checks looked fine (light text on dark background generally has strong contrast) but weren't run through a contrast calculator individually. | 1 | Time-boxed to the highest-confidence, highest-frequency issues found; flagging as an area for a dedicated contrast audit if desired. |

## Strengths

- **Cohesive brand identity carried through every page** — the dark green (`#104334`/`#21735B`/`#144A3A`) palette, Red Hat Display/Onest font pairing, and rounded-card visual language are applied consistently across the homepage, department pages, program listings, and About Us, without drifting into generic "AI palette" territory.
- **Program cards and pagination already have solid interactive affordances** — the `activity`/`research`/`competition` card links had `focus:ring-4 focus:ring-green-300` before this audit even started, and the custom Tailwind pagination partial already includes `role="navigation"` and `aria-label="Pagination Navigation"`. These were left untouched because they were already correct.
- **Sensible loading-order animation on the homepage hero** (logo → nav → typing headline → CTA) reads as an intentional, well-sequenced entrance rather than clutter, and the horizontal program scroller degrades gracefully to a grid when there are 3 or fewer items.
- **Controller-to-view data contracts are clean** — `DepartmentController` cleanly distinguishes the list route (`fordeptpage`) from the detail route (`showDetail`) via `@isset($department)`/`@isset($departments)` in the same template, which made it possible to add the missing `<h1>` without duplicating the view.
- **Mobile navigation (hamburger + full-screen menu) already closes correctly on link click, overlay click, and outside click** — the underlying interaction logic was solid; it only needed ARIA state added on top, not rebuilt.

## Verification

**`npm run build`:**
```
vite v6.4.3 building for production...
transforming...
✓ 56 modules transformed.
rendering chunks...
computing gzip size...
public/build/manifest.json             0.27 kB │ gzip:  0.14 kB
public/build/assets/app-Devd0-YY.css  47.00 kB │ gzip:  8.21 kB
public/build/assets/app-DUr89oQr.js   48.62 kB │ gzip: 18.58 kB
✓ built in 440ms
```

**`php artisan test`:** `Tests: 51 passed (145 assertions)` — full suite green, no regressions.

**Curl verification (server on port 8010), all returning HTTP 200 with the compiled `build/assets/app-*.css` link present:**

| Route | HTTP | CSS link present |
|---|---|---|
| `/` | 200 | yes |
| `/AboutUs` | 200 | yes |
| `/departement` | 200 | yes |
| `/departement/{slug}` (bonus check) | 200 | yes |
| `/Activity` | 200 | yes |
| `/Research` | 200 | yes |
| `/Competition` | 200 | yes |

Live-checked side effects of the fixes:
- The dev database currently has 0 seeded `Programs` rows, which meant `/Activity`, `/Research`, and `/Competition` were silently rendering the empty gap this audit flagged — confirmed by curling the pages post-fix and seeing the new "No activity/research/competition programs yet." messages render exactly as intended.
- `/AboutUs` now renders `alt="Integration Test Dept 1785556249"` (the one leftover seeded department) instead of an empty `alt=""`, confirming the `$dept['alt']` → `$dept->name` fix works against real data.
- `/departement/{slug}` renders exactly one `<h1>` (the department name); the conditional `sr-only` "Our Departments" `<h1>` correctly does not render on that route, confirming no duplicate top-level heading.
