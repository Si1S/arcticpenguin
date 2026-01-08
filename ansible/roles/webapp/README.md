# Rôle — webapp

Ce rôle déploie une application Symfony packagée en Docker Compose (PHP-FPM + Nginx + PostgreSQL) en récupérant le dossier `webapp/` depuis le dépôt GitHub, puis en générant les fichiers `.env` nécessaires et en (re)lançant la stack.

## Fonctionnalités

- Clone le dépôt GitHub défini par `arcticrepo` dans un répertoire temporaire, puis copie uniquement le dossier `webapp/` vers `webapp_dir` (déploiement “folder-only”).
- Crée les utilisateurs locaux dédiés (`webapp` et `postgres-app`) et prépare l’arborescence (logs Nginx, répertoires Postgres, répertoires Symfony `var/`).
- Rend les fichiers de configuration :
  - `.env` (Docker Compose) depuis `webapp.env.j2` avec les variables DB.
  - `symfony.env` depuis `symfony.env.j2` avec `APP_SECRET` et `DATABASE_URL` (secrets via Vault).
- Optionnel : exécute `composer install` (seulement si `vendor/autoload.php` est absent) avec une règle UFW sortante temporaire 80/443 si `webappuseufwtemprules=true`.
- Démarre/redémarre la stack via `community.docker.docker_compose_v2` et peut redémarrer des services ciblés (`php`, `db`).

## Stack applicative (Docker Compose)

Le `docker-compose.yml` de l’application définit typiquement :
- `php` : image construite depuis `webapp/docker/Dockerfile`
- `nginx` : `nginx:alpine`, exposé en local sur `127.0.0.1:8080`, avec montage du code Symfony en lecture seule et des conf Nginx depuis `/opt/webapp/docker/nginx/`.
- `db` : `postgres:16-alpine`, exposé en local sur `127.0.0.1:5432`, avec volumes persistants sous `/data/postgres/arctic/`.

L’application utilise deux réseaux Docker (`frontend` et `backend`) avec des sous-réseaux dédiés.

## Nginx & Cloudflare

- La conf Nginx inclut `cloudflare-realip.conf` et utilise `CF-Connecting-IP` pour récupérer l’IP réelle du client derrière Cloudflare.
- Un blocage “user-agent” est présent pour refuser explicitement certains outils de scan (`gobuster`, `dirsearch`, `ffuf`, `wfuzz`).
- Les logs Nginx sont montés vers l’hôte (utile pour Fail2Ban).

## Variables

Variables de déploiement :
- `arcticrepo` (URL Git), `webapp_version` (branche/tag/commit), `webapp_tmp_dir`, `webapp_dir`.

Variables DB / secrets (souvent Vault) :
- `webapp_db_name`, `webapp_db_user`, `webapp_vault_db_password`, `webapp_vault_app_secret`.

## Utilisation

Ce rôle est utilisé par `playbooks/webapp.yml` sur l’hôte `web01`.

Lancer le déploiement :
```bash
ansible-playbook playbooks/webapp.yml -K
