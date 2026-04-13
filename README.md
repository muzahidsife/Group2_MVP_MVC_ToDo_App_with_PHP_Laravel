# Laravel ToDo App

A complete MVC ToDo application built with **Laravel 12**, featuring authentication, CRUD operations, filtering, search, soft deletes, activity logging, dark mode, and comprehensive tests.

## Features

1. ✅ User registration, login, logout
2. ✅ User profile update (name, email, password)
3. ✅ Create, edit, delete tasks (with soft delete)
4. ✅ View task details with activity history
5. ✅ Toggle task status (pending/completed)
6. ✅ Due dates with overdue highlighting
7. ✅ Priority levels (low, medium, high)
8. ✅ Task categories with colors
9. ✅ Task tags (many-to-many)
10. ✅ Search tasks by title/description
11. ✅ Filter by status, category, priority
12. ✅ Sort by due date, created date, priority
13. ✅ Pagination (15 per page)
14. ✅ Dashboard with summary stats
15. ✅ Authorization (users see only their own data)
16. ✅ Validation with friendly error messages
17. ✅ Trash: restore or permanently delete tasks
18. ✅ Dark mode toggle
19. ✅ Email notification for upcoming due tasks
20. ✅ Activity log tracking task changes
21. ✅ Seeder with demo data
22. ✅ PHPUnit feature + unit tests

## MVC Architecture

This project follows Laravel's MVC (Model-View-Controller) pattern:

- **Models** (`app/Models/`): Eloquent models define database structure, relationships (belongsTo, hasMany, belongsToMany), scopes for filtering, and business logic helpers.
- **Views** (`resources/views/`): Blade templates handle presentation. Layouts provide consistent structure; individual views render data passed from controllers.
- **Controllers** (`app/Http/Controllers/`): Handle HTTP requests, coordinate between models and views, and return responses. Form Request classes handle validation separately.

Additional architectural elements:
- **Policies** enforce authorization (ownership checks)
- **Form Requests** validate input with custom error messages
- **Services** (ActivityLogService) encapsulate reusable business logic
- **Factories & Seeders** generate test/demo data
- **Migrations** define the database schema

## Tech Stack

- PHP 8.2+ / Laravel 12
- MySQL
- Blade templates + Tailwind CSS
- Eloquent ORM
- PHPUnit for testing

## Setup Instructions

### Prerequisites
- PHP 8.2+
- Composer
- MySQL
- Node.js & npm

### Installation

```bash
# 1. Clone or extract the project
cd laravel-todo

# 2. Install PHP dependencies
composer install

# 3. Copy environment file and generate key
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
# DB_DATABASE=laravel_todo
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 5. Create the database
mysql -u root -p -e "CREATE DATABASE laravel_todo"

# 6. Run migrations
php artisan migrate

# 7. Seed demo data (optional)
php artisan db:seed

# 8. Install frontend dependencies and build
npm install
npm run build

# 9. Start the development server
php artisan serve
```

### Demo Login
After seeding: `demo@example.com` / `password`

### Running Tests

```bash
php artisan test
```

### Email Reminders (optional)

Schedule the reminder command to run daily:
```bash
php artisan tasks:send-reminders
```

Or add to `app/Console/Kernel.php`:
```php
$schedule->command('tasks:send-reminders')->dailyAt('08:00');
```

## Database Schema

```
users          → id, name, email, password, timestamps
categories     → id, user_id (FK), name, color, timestamps
tags           → id, user_id (FK), name, timestamps
tasks          → id, user_id (FK), category_id (FK nullable), title, description,
                 status (enum), priority (enum), due_date, completed_at,
                 timestamps, soft_deletes
task_tag       → id, task_id (FK), tag_id (FK) [pivot]
activity_logs  → id, user_id (FK), task_id (FK nullable), action, description,
                 changes (JSON), timestamps
```

## License

MIT
