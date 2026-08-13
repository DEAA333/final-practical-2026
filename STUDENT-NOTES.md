# Student Notes — Laravel 13 Practical Exam

## 1. Student

- **Name:** Deaa Abu Hasaballa
- **Student number:** 2149011002
- **Repository:** https://github.com/DEAA333/final-practical-2026
- **Branch:** master

---

## 2. A note on task numbering

This repository contains two task lists that diverge after task 9:

| Instructions PDF | `EXAM-STUDENT.md` (in repo) |
| --- | --- |
| 11 numbered tasks | 14 numbered tasks |
| 10 = Rating | 10 = Request details page, 11 = Rating |
| 11 = Debugging | 12 = Debugging |
| — | 13 = N+1 query |
| — | 14 = Individual surprise task |

My commit messages follow the **PDF numbering** (`Task 1` … `Task 11`), plus one extra
commit for the N+1 work, which is task 13 in `EXAM-STUDENT.md`. The PDF also lists
"Eloquent Queries" among the assessed skills, so that work is covered by both documents.

---

## 3. Tasks completed

| # (PDF) | Task | Status | Commit |
| --- | --- | --- | --- |
| 1 | Run project, migrate & seed | Done | `Task 1 Complete` |
| 2 | Models and relationships | Done | `Task 2 Complete` |
| 3 | Request listing with customer/technician | Done | delivered inside `Task 2` / `Task 4` commits |
| 4 | Search and filters | Done | `Task 4 Complete` |
| 5 | Pagination preserving filters | Done | `Task 5 Complete` |
| 6 | Create request | Done | `Task 6 Complete` |
| 7 | Server-side validation + Blade errors | Done | `Task 7 Complete` |
| 8 | Edit / Update with old values | Done | `Task 8 Complete` |
| 9 | Authorization | Done | `Task 9 Complete` |
| 10 | Rating rules | Done | `Task 10 Complete` |
| 11 | Debugging | Done | `Task 11 Complete` |
| 13 (`EXAM-STUDENT.md`) | Remove N+1 query risk | Done | `Task 13 Complete` |
| 14 (`EXAM-STUDENT.md`) | Individual surprise task | **Not assigned to me** | — |

> **Task 3 has no dedicated commit.** The listing work (showing ID, title, customer,
> technician, priority and status through Eloquent relationships) was already delivered
> as part of the `Task 2 Complete` and `Task 4 Complete` commits. I am noting it here
> because the instructions ask for one clear commit per task.

---

## 4. Intentional bugs I found and fixed

| # | Bug | Where | Fix |
| --- | --- | --- | --- |
| 1 | `store()` validated only `title`, so every other field was discarded and the insert crashed with `NOT NULL constraint failed: maintenance_requests.customer_id` | `MaintenanceRequestController@store` | Validate and save all fields; `status` defaults to `pending` |
| 2 | `technician_id` used `exists:users,id`, so **any** user (including the admin) could be assigned as a technician | validation rules | `Rule::exists('users','id')->where('role','technician')` |
| 3 | **Route model binding was broken.** `Route::resource('requests', ...)` generates `{request}`, but controllers typehinted `MaintenanceRequest $m`. The names did not match, so Laravel injected an empty model and `show`, `edit`, `update`, `destroy`, rating `store` and the API `show` all returned HTTP 500 | `routes/web.php` + 3 controllers | `->parameters(['requests' => 'maintenanceRequest'])` and renamed `$m` to `$maintenanceRequest` |
| 4 | `MaintenanceRequestPolicy` existed but was **never called** — zero `authorize()`, `Gate` or `@can` in the whole project, so any technician could edit or delete any request | controllers + views | `Gate::authorize()` in `show`/`edit`/`update`/`destroy` + `@can` in views |
| 5 | Rating rules missing: no "completed only" check, no "correct customer" check, no "one rating per request" check | `RatingController@store` | All three enforced in the backend, plus a DB unique index |
| 6 | `routes/api.php` and the API controller existed but were **never registered**, so every `/api/*` route returned 404 | `bootstrap/app.php` | Added `api: __DIR__.'/../routes/api.php'` |
| 7 | Login errors were sent with `withErrors()` but the login view had no code to display them — wrong credentials produced a silent bounce | `auth/login.blade.php` + `AuthController` | Render `$errors`, keep the email with `withInput()` |
| 8 | `bootstrap/providers.php` registered `App\Providers\AppServiceProvider` but the class did not exist | `app/Providers/` | Created the standard provider |
| 9 | The instructor's own tests could not run: `phpunit.xml`, `tests/TestCase.php` and `tests/CreatesApplication.php` were missing | test scaffolding | Created them — all 5 original tests now pass |
| 10 | Seeder created only 3 customers and 4 requests, so pagination (5 per page) never appeared and the repo's own tests expecting 8 customers / 10+ requests failed | `DatabaseSeeder` | Extended to 8 customers and 12 requests |
| 11 | Filter dropdowns never marked the selected option, so filters looked lost after paginating | `requests/index.blade.php` | `@selected(request('status') === $s)` |
| 12 | The technician filter was implemented in the controller but had **no field in the form** | `requests/index.blade.php` | Added the technician `<select>` and a Reset link |

---

## 5. Most important changes

1. **Validation rules centralised.** `store()` and `update()` shared duplicated rules that
   could drift apart. They now both call `private function rules(bool $withStatus)`, with
   `$withStatus` because the create form has no `status` field while the edit form does.

2. **Authorization is enforced on the operation, not the button.** `Gate::authorize()` runs in
   `update()` as well as `edit()`. Hiding the Edit button does not stop a direct POST request,
   which I verified by sending one.

3. **Rating protected in three layers:** the Blade view hides the form, the controller rejects
   the request, and the database has a `unique` index on `maintenance_request_id` so even a
   race condition cannot create two ratings.

4. **Dashboard reduced from 4 queries to 1** using `selectRaw('status, count(*) as total')`
   with `groupBy('status')`.

---

## 6. Assumptions I made

1. **Technicians only see their assigned requests in the listing.** The policy already blocks
   them from opening other technicians' requests, so showing rows that would return 403 made
   no sense. Same rule applied to the dashboard counters.
2. **New requests always start as `pending`.** The create form has no status field, and letting
   the browser send a status would allow tampering.
3. **Only admins can delete**, including deleting a technician's own request. This follows the
   policy that was already in the project (`delete()` returns `$u->isAdmin()`).
4. **The rating form asks for a customer ID** because the project has no customer login — only
   admin and technician accounts exist. The backend still verifies that the submitted ID is
   exactly the customer who owns that request.
5. **Reasonable field lengths:** title 5–100, description 10–2000, comment max 1000.
6. Only validated data (`$v`) is passed to `create()` / `update()`, never `$request->all()`,
   to avoid mass-assignment problems.

---

## 7. Testing I performed

### Automated

`php artisan test` — **9 passed (21 assertions)**

- `BasicExamTest` (instructor's) — seeding, login, auth redirect
- `SmokeTest` (instructor's) — seeding, auth redirect
- `EagerLoadingTest` (mine) — proves lazy loading grows with row count, eager loading stays
  constant, the requests index has no N+1, and the dashboard uses a single query

### Manual (against a running `php artisan serve`)

| Area | What I checked | Result |
| --- | --- | --- |
| Pagination | `?status=pending&technician_id=2&page=2` | Filters survive in page links and in the dropdowns |
| Create | Valid data / no technician / missing data | Saved / saved with `NULL` / rejected with 5 messages |
| Validation | Assigning the admin as a technician | `The selected technician is invalid.` |
| Validation | Failed submit | `old()` restores title, description, date and dropdowns |
| Update | Changed customer, technician, priority and status at once | All four persisted, success message shown |
| Authorization | Technician opening another technician's request | 403 |
| Authorization | Technician sending a **direct POST** to update another's request | 403 |
| Authorization | Technician deleting his own request | 403 (admin only) |
| Authorization | Admin editing and deleting any request | Allowed |
| Rating | Pending request / wrong customer / score 0 / score 9 / 2000-char comment | All rejected |
| Rating | Valid rating, then a second rating on the same request | Saved, then rejected |
| Rating | Direct SQL duplicate insert | Blocked by the unique index |
| Missing record | `/requests/9999/edit` | 404, not 500 |
| API | `/api/requests/1` and `/api/requests?status=pending` | 200 with JSON |
| Login | Wrong password | Error shown, email preserved |

### Two changes I made *after* testing

1. **Added `orderByDesc('id')` to the listing query.** While testing pagination I noticed all
   seeded rows shared the same `created_at`, so `latest()` alone produced an unstable order and
   a row could appear on two pages or vanish. The secondary sort makes paging deterministic.
2. **Added a `unique` index on `ratings.maintenance_request_id`.** The controller check was
   enough for normal use, but testing made me realise two simultaneous submissions could still
   slip through, so I enforced the rule at the database level too.

---

## 8. Known limitations

1. **No customer authentication.** Customers cannot log in, so the rating form asks for a
   customer ID instead of using the logged-in user. The backend still verifies it, but a proper
   solution would be a customer guard.
2. **Task 3 has no dedicated commit** (explained in section 3).
3. **Task 14 (the individual surprise task) was not assigned to me**, so it is not implemented.
4. **Delete has no confirmation dialog** — a single click deletes the request.
5. **A technician can reassign his own request to another technician**, which then removes his
   own access. The exam rules did not specify whether this should be blocked.
6. The default pagination view is Tailwind-based while this project uses plain CSS, so I added
   a few CSS rules in the layout instead of publishing a custom pagination view.

---

## 9. AI tools used

claude
---

## 10. How to run

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
php artisan test
```

**Login:** `admin@example.com` / `password` (admin) — `ahmed@example.com` / `password` (technician)
