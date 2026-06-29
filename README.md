# Trustindex

A Symfony web application where users can register, log in, and leave reviews for companies.  
The homepage displays all reviews with sorting and filtering. Each company has a dedicated detail page and a statistics
page aggregating review counts and average ratings.

## Features

- **User authentication** – registration, login, logout (Symfony built‑in security)
- **Review management** – authenticated users can submit reviews for any company
- **Star ratings** – 1‑5 stars with visual rendering using Bootstrap Icons
- **Company list & stats** – see all reviewed companies, number of reviews, and average rating
- **Detail view** – read the full review and metadata (author, date)
- **DataTables** – sortable, searchable tables with pagination on home and company pages
- **Turbo & Stimulus** – SPA‑like navigation without full page reloads
- **Form themes** – Bootstrap 5 styling for all forms
- **Validation** – server‑side constraints (not null, range, email) with user‑friendly error messages

## Tech Stack

- PHP 8.2+, Symfony 7
- Doctrine ORM (PostgreSQL)
- Twig, Bootstrap 5, Bootstrap Icons
- DataTables + Stimulus + Turbo Drive
- AssetMapper for frontend assets
- Docker (database service)

## Prerequisites

- PHP 8.2 or higher with common extensions (pdo_pgsql, intl, mbstring, etc.)
- Composer 2
- Docker & Docker Compose (for the database)
- Symfony CLI (optional, but recommended)

## Installation

1. **Clone the repository**

   ```bash
   git clone <repository-url>
   cd trustindex

2. **Install PHP dependencies**

   ```bash
   composer install

3. **Configure environment variables**

   ```bash
   cp .env.example .env
   ```
   Make sure the PostgreSQL connection string matches your Docker setup


4. **Start the database**

   ```bash
   cp .env.example .env

5. **Create the database and run migrationse**

    ```bash
    php bin/console doctrine:database:create --if-not-exists
    php bin/console doctrine:migrations:migrate --no-interaction

6. **Start the Symfony development server**

    ```bash
    symfony server:start
   
## Running Tests
Before running the test, create the test database:
```bash
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:create --env=test
```

Execute:
```bash
php bin/phpunit
```
