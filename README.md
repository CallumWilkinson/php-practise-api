# Procurement Request API

A small Symfony 8 API for working with procurement requests. The current codebase exposes list, create, and submit workflows over HTTP.

## Stack

- PHP 8.4+
- Symfony 8
- Doctrine ORM
- PostgreSQL
- PHPUnit 13
- PHPStan

## Current Project Shape

The codebase is organised as a simple layered Symfony application:

- `src/Controller`
  HTTP entry points. `ProcurementRequestController` currently handles:
  - `GET /requests`
  - `POST /requests`
  - `POST /requests/{id}/submit`
- `src/Application/ProcurementRequest`
  Application services and repository contract:
  - `CreateProcurementRequestService`
  - `ListProcurementRequestsService`
  - `SubmitProcurementRequestService`
  - domain-specific exceptions
- `src/Entity`
  Doctrine entity for `ProcurementRequest`.
- `src/Repository`
  Doctrine repository implementation for persistence.
- `src/Mappers`
  Response mapping from entity objects to JSON-ready arrays.
- `tests/Application`
  Unit tests for application services.
- `tests/Controller`
  Functional HTTP tests for the Symfony controller. `GET /requests` and `POST /requests` are covered here today.
- `tests/Mappers`
  Mapper tests.
- `tests/TestHelpers`
  Test builder and fake repository used by unit tests.
- `migrations`
  Doctrine migration history.

## Domain Model

The main domain object is `ProcurementRequest`, which currently stores:

- `id`
- `title`
- `description`
- `status`
- `createdAt`

Current statuses used by the application layer:

- `draft`
- `submitted`

## Current HTTP API

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

Creates a new procurement request in `draft` status.

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

Validation errors currently return `400 Bad Request` with a simple JSON error payload.

### `POST /requests/{id}/submit`

Submits a draft procurement request by ID.

Successful response:

```json
{
    "id": 1,
    "title": "Office fit-out",
    "description": "Procurement for office fit-out works",
    "status": "submitted",
    "createdAt": "2026-05-08T10:15:00+00:00"
}
```

Current error responses:

- `404 Not Found` when the request does not exist
- `409 Conflict` when the request is not in `draft` status

## Internal Application Flows

The application layer currently supports three use cases:

- create a procurement request
- list procurement requests
- submit a draft procurement request

The submit flow in `SubmitProcurementRequestService` enforces:

- not found requests raise a domain exception
- only requests in `draft` status can transition to `submitted`

## Local Setup

1. Install PHP dependencies.

```powershell
composer install
```

2. Start the local database services.

```powershell
docker compose up -d
```

This starts:

- PostgreSQL on `localhost:5432`
- pgAdmin on `http://localhost:5050`

3. Run database migrations.

```powershell
php bin/console doctrine:migrations:migrate
```

4. Start the Symfony app with your preferred local server.

If you use Symfony CLI:

```powershell
symfony server:start
```

Or use the existing Composer helper to bring up Docker, run migrations, and start the Symfony server:

```powershell
composer start
```

## Useful Commands

Run the test suite:

```powershell
vendor\bin\phpunit
```

Run static analysis:

```powershell
vendor\bin\phpstan analyse
```

Run PHP linting via the Composer script:

```powershell
composer lint
```

Run the main local quality checks:

```powershell
composer check
```

Run the PHPUnit suite via Composer:

```powershell
composer test
```

Stop the local app stack:

```powershell
composer stop
```
