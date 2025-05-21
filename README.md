# 🎓 Laravel Student Meal Management System

An API-first Laravel application to manage student meal distribution, surveys, and merchant-specific pricing. Built with clean architecture, role-based permissions, and secure token-based authentication for seamless student and admin/merchant interaction.

---

## 🚀 Features

-   🔐 Role-based access control using **Spatie Laravel Permission**
-   👤 Student login via `student_number` and password (with **Sanctum** tokens)
-   🍽️ Time-bound meals (`time_from` / `time_to`)
-   💰 Merchant-specific meal pricing with `effective_date`
-   📋 Dynamic student meal surveys with JSON-based radio question options
-   ✅ Optional survey submissions (e.g., Yes / No / Maybe)
-   📦 Fully structured API responses with **pagination**, **collections**, and **resources**

---

## 🛠 Tech Stack

-   **Laravel 12**
-   **PHP 8.2+**
-   **MySQL / MariaDB**
-   **Laravel Sanctum** (API auth)
-   **Spatie Laravel Permission** (role/permission management)

---

## ⚙️ Installation & Setup

### 🧾 Requirements

-   PHP 8.2 or higher
-   Composer
-   MySQL
-   A server or local dev environment (e.g., cPanel, Forge, XAMPP, etc.)

### 🔧 Setup Steps

#### 2. Create Your `.env` File

```bash
cp .env.example .env
```

> Or simply copy and paste contents of `.env.example` manually.

#### 3. Install Dependencies

```bash
composer install
```

If your system's PHP version is lower than required (for dev/test use only):

```bash
composer install --ignore-platform-reqs
```

#### 4. Generate Application Key

```bash
php artisan key:generate
```

#### 5. Link the Storage Folder

```bash
php artisan storage:link
```

#### 6. Set Storage Permissions

```bash
chmod -R 755 storage/
```

> For production, use more restrictive permissions like `755` depending on server config.

#### Migrate Database

```bash
php artisan migrate
```

#### Database Seeding

```bash
php artisan db:seed
```

## 🔐 Authentication

This app uses Laravel Sanctum to provide token-based authentication for students.

Students log in via API with:

-   `student_number`
-   `password`

Tokens are issued on login and required for all protected endpoints.

---

## 📮 API Structure

API endpoints are organized under `/api/student` with full separation of student-specific logic. Authenticated requests require Bearer token headers.

> This system is licensed for Kuwait University use only. Reuse or redistribution is prohibited.

---

## 🧪 Testing

```bash
php artisan test
```

---

## 📄 License

**This project is proprietary and restricted to Kuwait University. Not for public redistribution or reuse.**

---

## 🤝 Contributing

Contributions are not accepted for this private system.
