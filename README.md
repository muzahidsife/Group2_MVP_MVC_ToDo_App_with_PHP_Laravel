# ✅ Laravel ToDo — Task Manager App

A full-stack **Task Manager** web application built with **Laravel 12** following the MVC architectural pattern. Users can manage tasks with categories, tags, priorities, due dates, and a full activity log — all behind a secure authentication system.

---

## 🚀 Features

- 🔐 **Authentication** — Register, login, logout, and profile management
- 📋 **Task CRUD** — Create, view, edit, delete, and restore tasks
- 🔍 **Search & Filter** — Filter by status, category, priority; sort by due date or creation
- 🗂️ **Categories & Tags** — Organise tasks with user-owned categories and many-to-many tags
- ⚡ **Priority Levels** — Low, Medium, High priority with smart sorting
- 📅 **Due Dates** — Set deadlines with overdue detection
- 🗑️ **Soft Deletes & Trash** — Deleted tasks go to trash; restore or permanently delete
- 📜 **Activity Log** — Every task action is automatically recorded
- 🛡️ **Policies** — Users can only access and manage their own data
- 📱 **Responsive UI** — Built with Tailwind CSS, compiled via Vite

---

## 🛠️ Tech Stack

| Layer      | Technology              |
|------------|-------------------------|
| Backend    | Laravel 12, PHP ^8.2    |
| Frontend   | Blade Templates, Tailwind CSS 3.x |
| Bundler    | Vite 6                  |
| Database   | MySQL 8.0               |
| ORM        | Eloquent                |
| Auth       | Laravel Breeze (custom) |
| Testing    | PHPUnit 11              |

---

## ⚙️ Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/your-username/laravel-todo.git
cd laravel-todo

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file and configure it
cp .env.example .env
# → Set DB_DATABASE, DB_USERNAME, DB_PASSWORD in .env

# 5. Generate application key
php artisan key:generate

# 6. Create the database
# Run this in MySQL: CREATE DATABASE laravel_todo;

# 7. Run migrations and seed demo data
php artisan migrate --seed

# 8. Start the development servers (two terminals)
php artisan serve       # Terminal 1 → http://localhost:8000
npm run dev             # Terminal 2 → Vite asset server
```

---

## 🗄️ Database Schema

| Table           | Description                                      |
|-----------------|--------------------------------------------------|
| `users`         | Registered user accounts                        |
| `tasks`         | Core tasks with status, priority, due date       |
| `categories`    | User-owned task categories                      |
| `tags`          | User-owned labels (many-to-many with tasks)     |
| `task_tag`      | Pivot table for Task ↔ Tag relationship         |
| `activity_logs` | Audit log for all task lifecycle events         |

---

## 🔑 Demo Account

After seeding, a demo account is available:

```
Email:    demo@example.com
Password: password
```

> Comes pre-loaded with 4 categories, 4 tags, and 20 sample tasks.

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/     # TaskController, CategoryController, TagController, Auth/*
│   └── Requests/        # Form validation (StoreTaskRequest, UpdateTaskRequest, …)
├── Models/              # User, Task, Category, Tag, ActivityLog
└── Policies/            # TaskPolicy, CategoryPolicy, TagPolicy
database/
├── migrations/          # 6 migration files
├── factories/           # Faker model factories
└── seeders/             # DatabaseSeeder
routes/
└── web.php              # All application routes
resources/views/         # Blade templates
```

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).
