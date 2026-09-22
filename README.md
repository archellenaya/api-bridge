# APIBridge

APIBridge is a Laravel-based multi-tenant platform for managing tenant infrastructure, source connectors, API endpoints, queue/cache processing, and admin operations.

## Overview

This project includes:

- platform-level admin and tenant management
- tenant isolation for per-tenant databases and domains
- connector-based source integrations for REST APIs
- queue and cache integration with Redis
- endpoint orchestration, logging, and metrics
- tenant settings and operations visibility

## Quick start

### Prerequisites

- Docker and Docker Compose
- PHP 8.3+
- Composer

### Local runtime

```bash
docker compose -f docker-compose.yml up -d --build
```

Then open:

- http://localhost:8000
- http://localhost:8000/admin/login
- http://localhost:8000/api/v1/health

## Project phases

The app has been implemented across these project phases:

- Phase 0: bootstrap and runtime
- Phase 1: core multi-tenant foundation
- Phase 2: source connector layer
- Phase 3: queue and cache integration
- Phase 4: API platform and endpoint orchestration
- Phase 5: admin and operations

See [docs/project-guide.md](docs/project-guide.md) for the complete summary and architecture notes.

## Key configuration files

- [docker-compose.yml](docker-compose.yml)
- [.env](.env)
- [.env.example](.env.example)
- [config/tenancy.php](config/tenancy.php)
- [config/database.php](config/database.php)
- [config/queue.php](config/queue.php)
- [config/cache.php](config/cache.php)

## Verification

Run the focused regression suite with:

```bash
php artisan test --filter='PhaseFive|PhaseFour|PhaseThree|PhaseTwo|PhaseOne'
```

This suite verifies the app phases together and is the current project health check.

## Notes

- Redis support is required for the queue and cache runtime.
- The test environment uses SQLite in-memory configuration while the local runtime uses the Docker stack.
- The project is intended to evolve into a production-ready multi-tenant API platform with admin controls and tenant-connected sources.

## License

This project is configured as a Laravel application and follows the standard project conventions used by the repository.
