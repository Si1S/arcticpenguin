# Rôle — monitoring

Ce rôle déploie une stack de supervision basée sur Docker Compose (Prometheus, Grafana, Alertmanager, Blackbox Exporter et cAdvisor) en récupérant la configuration depuis le dépôt GitHub, puis en rendant les fichiers (templates) nécessaires avant de lancer/redémarrer les services.

## Ce que fait le rôle

- Crée l’utilisateur système de supervision et les répertoires de travail (ex: `monitoring_user`, `monitoring_dir`).
- Clone le dépôt GitHub défini par `arctic_repo` dans un répertoire temporaire, puis copie uniquement le dossier `monitoring/` vers le répertoire final.
- Génère les fichiers de configuration depuis templates (ex: `.env`, `prometheus.yml`, `web.yml`, règles d’alerting, `alertmanager.yml`, configuration Blackbox).
- Redémarre la stack (ou certains conteneurs) via des handlers utilisant `docker compose`.

## Services déployés (Docker Compose)

La stack attend typiquement un `docker-compose.yml` avec des services du type :
- **prometheus** (image `prom/prometheus`) avec montage de `prometheus.yml`, `web.yml` et des règles, rétention TSDB, et `--web.external-url`.  
- **grafana** (image `grafana/grafana`) avec variables `GF_SECURITY_ADMIN_USER` / `GF_SECURITY_ADMIN_PASSWORD` alimentées par `.env`.  
- **alertmanager** (image `prom/alertmanager`) avec `alertmanager.yml` monté en volume.  
- **blackbox exporter** (image `quay.io/prometheus/blackbox-exporter`) avec `blackbox.yml`.  
- **cadvisor** (image `gcr.io/cadvisor/cadvisor`) pour la visibilité conteneurs/hôte (volumes système en lecture seule).  

Les volumes persistants (ex: `prometheus-data`, `grafana-storage`) assurent la conservation des données (métriques, dashboards/configuration Grafana).

## Utilisation

Ce rôle est utilisé par `playbooks/monitoring.yml` et cible l’hôte `mon01`.

```bash
ansible-playbook playbooks/monitoring.yml -K
