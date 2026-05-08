# Procurement Request API

A small Symfony API for creating and listing procurement requests.

## Stack

- PHP 8.4+
- Symfony 8
- Doctrine ORM
- PostgreSQL
- PHPUnit
- PHPStan

## Features

- Create a procurement request
- List procurement requests
- Persist data with Doctrine
- Run tests and static analysis locally

## API Endpoints

### `GET /requests`

Returns a JSON array of procurement requests.

Example response:

```json
[
    {
        "id": 1,
        "title": "Office fit-out",
        "description": "Procurement for office fit-out works",
        "status": "draft",
        "createdAt": "2026-05-08T10:15:00+00:00"
    }
]
```

### `POST /requests`

Creates a new procurement request.

Example request:

```json
{
    "title": "Office fit-out",
    "description": "Procurement for office fit-out works"
}
```

Example response:

```json
{
    "id": 1,
    "title": "Office fit-out",
    "description": "Procurement for office fit-out works",
    "status": "draft",
    "createdAt": "2026-05-08T10:15:00+00:00"
}
```

Validation errors return `400 Bad Request`.

## Local Setup

1. Install PHP dependencies:

```powershell
composer install
```

2. Start the database services:

```powershell
docker compose up -d
```

3. Run database migrations:

```powershell
php bin/console doctrine:migrations:migrate
```

4. Start the application with your preferred local PHP server.

If you use Symfony CLI:

```powershell
symfony server:start
```

## Useful Commands

Run tests:

```powershell
vendor\bin\phpunit
```

Run static analysis:

```powershell
vendor\bin\phpstan analyse
```

Run the combined project checks:

```powershell
composer build
```
