<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requirements

Before installing the project, make sure you have the following installed:

- PHP 8.2 or higher
- Composer
- Node.js 20 or higher
- MySQL or another supported database

You can check your installed versions:

```bash
php -v
composer -V
node -v
npm -v
```

## Installation

### 1. Install PHP dependencies

```bash
composer install
```

### 2. Install frontend dependencies

```bash
npm install
```

### 3. Create the environment file

Copy the example environment file:

```bash
cp .env.example .env
```

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 4. Generate the application key

```bash
php artisan key:generate
```

### 5. Configure the database

Open the `.env` file and configure your database:

```env
APP_NAME="Laravel Vite Project"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

Create the database before running the migrations.

### 6. Run migrations

```bash
php artisan migrate
```

If the project contains seeders:

```bash
php artisan migrate --seed
```

## Running the Project

Laravel and Vite need to run during development.

### Start Laravel

```bash
php artisan serve
```

Laravel will normally be available at:

```text
http://127.0.0.1:8000
```

### Start Vite

In another terminal:

```bash
npm run dev
```

Vite will start the frontend development server and provide hot module replacement.

## Development Workflow

For the best development experience, open two terminals.

**Terminal 1:**

```bash
php artisan serve
```

**Terminal 2:**

```bash
npm run dev
```

Then open:

```text
http://127.0.0.1:8000
```

## Build Assets for Production

To create optimized production assets:

```bash
npm run build
```

The compiled assets will be generated in the `public/build` directory.

For production deployment, make sure the generated assets are included in your deployment process.

## Useful Artisan Commands

Clear Laravel caches:

```bash
php artisan optimize:clear
```

Run migrations:

```bash
php artisan migrate
```

## Storage Link

If your application uses Laravel's public storage:

```bash
php artisan storage:link
```
## Environment Variables

Never commit your `.env` file to Git.

The `.env` file can contain sensitive information such as:

- Database credentials
- Application keys
- API keys
- Mail credentials
- Third-party service credentials

Use `.env.example` to document the required environment variables.
