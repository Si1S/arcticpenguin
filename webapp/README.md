# 🌍 Webapp (Symfony + Docker)

Webapp Symfony déployée via Docker Compose (Nginx + PHP-FPM + PostgreSQL).

## Structure

- `docker-compose.yml` : stack Docker.
- `docker/` : Dockerfile + conf Nginx.
- `symfony/` : code de l’application.

## Démarrage

```bash
docker compose up -d --build
```
