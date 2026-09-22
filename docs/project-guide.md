# APIBridge Project Guide

## Overview

APIBridge is a Laravel multi-tenant application for platform administration, tenant isolation, source connectors, and endpoint orchestration. It supports:

- platform administration and tenant lifecycle management
- tenant-specific application databases and domains
- source connector registration and execution
- Redis-backed queue and cache handling
- request logging, usage metrics, and tenant settings

## Architecture

### Platform layer

The platform layer handles:

- admin authentication
- tenant registry and domains
- subscriptions and plan configuration
- platform settings and operational monitoring

### Tenant layer

Each tenant can own its own isolated runtime state:

- tenant database templates and per-tenant domains
- tenant users, API keys, sources, endpoints, logs, and settings
- tenant-aware cache and queue propagation

## Local runtime

The project is set up to run with Docker Compose for the local stack:

- app
- MySQL
- Redis

### Start services

```bash
docker compose -f docker-compose.yml up -d --build
```

### Application URL

- app: http://localhost:8000
- admin login: http://localhost:8000/admin/login
- health: http://localhost:8000/api/v1/health

## Configuration

The local app configuration is driven by environment variables in `.env` and the default template in `.env.example`.

Key defaults include:

- MySQL for the primary app database
- Redis for queue processing and cache
- platform auth guard config
- tenancy bootstrap settings

## Phase status

### Phase 0 — Bootstrap and runtime

Completed:

- Laravel app boots locally
- Docker Compose stack is valid for app, MySQL, and Redis
- local `.env` configuration is present
- app responds without fatal errors

### Phase 1 — Core multi-tenant foundation

Completed:

- platform and tenant database setup exists
- tenancy config is in place
- tenant resolution logic is implemented
- admin/auth scaffold exists
- tenant API routes exist
- health endpoint responds
- services and connector scaffolding are in place
- focused tests pass

### Phase 2 — Source connector layer

Completed:

- connector factory exists
- connector contract exists
- REST connector implementation exists
- source configuration validation exists
- execution abstraction exists
- error normalization exists

### Phase 3 — Queue and cache integration

Completed:

- queue driver configured for Redis
- cache driver configured for Redis
- tenant-aware propagation implemented for queue jobs
- cache keys are tenant-scoped
- queue smoke checks pass

### Phase 4 — API platform and endpoint orchestration

Completed:

- API key support exists
- tenant source endpoint registry exists
- transformation layer exists
- request logging exists
- usage metrics captured
- tenant settings supported

### Phase 5 — Admin and operations

Completed:

- tenant management models exist
- subscription management exists
- domain management exists
- admin settings and platform access patterns are defined
- operations dashboard summary exists

## Operational notes

- Redis support requires the PHP Redis extension in the environment.
- The test suite is configured to validate the same queue and cache defaults used by the application.
- The project uses SQLite in the test environment for the in-memory DB and Redis-backed runtime config for local execution.

## Verification commands

```bash
php artisan test --filter='PhaseFive|PhaseFour|PhaseThree|PhaseTwo|PhaseOne'
php artisan config:show queue.default
php artisan config:show cache.default
```

## Key project files

- [docker-compose.yml](../docker-compose.yml)
- [config/tenancy.php](../config/tenancy.php)
- [config/database.php](../config/database.php)
- [routes/tenant.php](../routes/tenant.php)
- [routes/web.php](../routes/web.php)
- [app/Providers/PhaseOneServiceProvider.php](../app/Providers/PhaseOneServiceProvider.php)
- [app/Services/Connectors](../app/Services/Connectors)
- [app/Jobs/ProcessTenantRequest.php](../app/Jobs/ProcessTenantRequest.php)
- [app/Services/Admin/OperationsDashboard.php](../app/Services/Admin/OperationsDashboard.php)

## Next steps

Potential next tasks include:

1. add real admin CRUD endpoints for tenants, domains, and subscriptions
2. add endpoint execution handlers for connector-backed requests
3. add persisted request metrics and dashboard APIs
4. add tenant creation and domain registration workflows
