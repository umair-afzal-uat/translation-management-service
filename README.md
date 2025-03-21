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

### **Docker Setup**

### **Step 1: Build and Run the Docker Containers**
Run the following commands to build and start the containers:
```bash
docker-compose up --build
docker-compose exec app composer i 
For Artisan Related Command:
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed --class=LocaleSeeder
docker-compose exec app php artisan db:seed --class=TranslationSeeder
docker-compose exec app php artisan test --coverage-html=coverage-report


```
if facing any issue run this:

```bash
docker-compose build --no-cache
docker-compose exec app composer i 
For Artisan Related Command:
docker-compose exec app php artisan db:seed --class=LocaleSeeder
docker-compose exec app php artisan db:seed --class=TranslationSeeder
docker-compose exec app php artisan test --coverage-html=coverage-report

```

This will start the following services:
- **Laravel Application**: Accessible at `http://localhost`.
- **phpMyAdmin**: Accessible at `http://localhost:8080`.
- **MySQL Database**: Running in the background.

### **Step 2: Access the Application**
- Open your browser and navigate to `http://localhost` to view the Laravel application.
- Use `http://localhost:8080` to access phpMyAdmin and manage the MySQL database.

---

## **Stopping the Containers**
To stop the containers, run:
```bash
docker-compose down
```

