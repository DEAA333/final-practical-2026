# Laravel Practical Exam – Maintenance Management System

Starter repository for a practical Laravel exam designed to assess real development ability while allowing controlled use of AI tools.

## Stack
- Laravel 13
- PHP 8.3+
- Blade
- Eloquent ORM
- SQLite/MySQL
- PHPUnit/Pest-compatible Laravel testing

## Student setup

```bash
git clone <repository-url>
cd laravel-practical-exam
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

Open http://127.0.0.1:8000

## Demo accounts

Admin:
- admin@example.com
- password

Technician:
- ahmed@example.com
- password

Technician:
- sara@example.com
- password

## Exam rules

AI tools may be used if the instructor allows them. Students are responsible for understanding every submitted change. The instructor may request a short explanation or live modification of any part of the project.

## Student tasks

See `EXAM-STUDENT.md`.

## Important

This repository intentionally starts incomplete. Students are expected to debug, complete, and extend it according to the exam sheet.
