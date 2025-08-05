# Laravel CRUD API Application

This repository contains a Laravel 12 application that provides CRUD API endpoints for managing Users, Posts, and Comments. It also includes an integrated Swagger UI for API documentation.

## Requirements

* PHP 8.2 or higher
* Composer
* MySQL (or any supported database)
* Extensions: `pdo_mysql`, `pdo_sqlite`, `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`

## Installation (Without Docker)

1. **Clone the repository**

   ```bash
   git clone https://github.com/codeofsolomon/example-app
   cd example-app
   ```

2. **Install dependencies**

   ```bash
   composer install
   ```

3. **Set up environment**

   ```bash
   cp .env.example .env
   ```

   Open `.env` and configure the following variables to match your MySQL setup:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=secret
   ```

4. **Generate application key**

   ```bash
   php artisan key:generate
   ```

5. **Run database migrations**

   ```bash
   php artisan migrate
   ```


## Running the Application

You can start the built-in PHP development server:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

The API will be accessible at: `http://127.0.0.1:8000`

## Swagger API Documentation

This project uses **L5-Swagger** for API documentation. After starting the application, navigate to:

```
http://127.0.0.1:8000/api/documentation
```

Here you can view and interact with all available endpoints.


