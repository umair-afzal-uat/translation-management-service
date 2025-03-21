# Translation Management Service

## 📌 Setup Instructions

### 1️⃣ Set Environment Variables
First, configure your `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 2️⃣ Run Migrations
Run the database migrations:
```sh
php artisan migrate
```

### 3️⃣ Seed the Database
Populate the database with necessary data:
```sh
php artisan db:seed --class=LocaleSeeder
```
```sh
php artisan db:seed --class=TranslationSeeder
```

### 4️⃣ Start the Application
Run the Laravel application:
```sh
php artisan serve
```
Your project will be available at `http://127.0.0.1:8000`.

## ✅ Running Tests & Coverage Report
To execute unit and feature tests with coverage:
```sh
php artisan test --coverage-html=coverage-report
```
The coverage report will be generated in the `coverage-report/` directory.

---

### 🚀 Enjoy Building with Laravel 12! 🎉

