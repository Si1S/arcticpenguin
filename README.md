# arcticpenguin

Projet final de formation qui illustre la conception et le déploiement d’une infrastructure complète, automatisée et sécurisée, combinant des outils de provisioning, de supervision et de CI/CD orientée sécurité.

L’objectif est de construire un environnement cohérent “infra + services” reposant sur Ansible pour l’automatisation, Docker pour la conteneurisation (webapp Symfony, monitoring, Nextcloud), et des briques de sécurité avancées (Wazuh, Cloudflare Tunnel, PKI)
​
## ⚠️ Note de sécurité
Ce repo contient des fichiers Ansible Vault pour un environnement de lab uniquement.
Les secrets ne sont pas utilisés en production.

## Contenu

**Ansible (infra & services)** : inventaire, variables, playbooks et rôles pour déployer un socle Linux + services (PKI Easy‑RSA, distribution de CA, monitoring, exporters, Cloudflare Tunnel, Nextcloud, Wazuh, webapp, Fail2ban).

**Webapp Symfony (Docker Compose)** : stack PHP-FPM + Nginx + PostgreSQL (compose, Dockerfile, conf Nginx, code Symfony).

**Monitoring (Docker Compose)** : Prometheus, Grafana, Alertmanager, Blackbox Exporter.

**Nextcloud (conteneur + config)** : docker-compose Nextcloud et fichiers de configuration (Apache + exemple LDAP).

**Sécurité / PKI** : CA via Easy‑RSA, génération de certificats (LDAPS + certificats internes Nextcloud/Wazuh) et distribution de ca.crt sur les hôtes Linux.

**Wazuh** : configuration serveur (indexer/manager/dashboard) pour superviser de la sécurité sur l’ensemble des environnements Linux, Windows et Docker. Grâce à l’intégration de règles de détection avancées (brute force, escalade de privilèges, connexions distantes), la connexion avec VirusTotal pour l’analyse automatique des menaces et l'analyse des logs du firewall centralisé pfsense.

**CI sécurité** : workflows GitHub Actions sur chaque push sur main et sur chaque Pull Request en chaînant Semgrep (SAST : scan statique du code Symfony/PHP, Docker et configs pour détecter des patterns de vulnérabilités) et Trivy FS (scan vulnérabilités + mauvaises configurations) puis en publiant les résultats au format SARIF dans l’onglet Security de GitHub. Un scan TruffleHog complète le tout en recherchant des secrets exposés (en différentiel sur PR ou sur l’ensemble du dépôt lors d’un push), avec l’option --only-verified pour ne remonter que les secrets vérifiés.

## Architecture

Schéma d’architecture du projet (contexte réseau + services).

![Schéma d’architecture](docs/architecture.jpg)

​Le schéma illustre notamment une exposition via Cloudflare Tunnel et une segmentation (Server/DMZ), avec une webapp derrière un reverse-proxy et une base de données sur un réseau “back”.

Certains éléments visibles sur le schéma (pfSense/Suricata, Proxmox, les contrôleurs de domaine et le stockage/backup externe) servent à décrire le contexte d’infrastructure dans lequel le projet s’exécute, mais ne sont pas pilotés par le code de ce dépôt.

## Structure du dépôt

- `ansible/` : automatisation infra (inventaire, variables, playbooks, rôles, collections).

- `webapp/` : application Symfony + stack Docker (compose, Dockerfile, conf Nginx, code Symfony).

- `monitoring/` : stack de supervision Docker Compose + .env.example.

- `nextcloud/` : stack Nextcloud (compose) + conf Apache + exemple LDAP.

- `docs/` : documentation et ressources

## Composants clés

- `cloudflare_tunnel` : installe/configure cloudflared et un service systemd (token via Vault).

- `webapp` : déploie la webapp Symfony via Docker Compose et génère les fichiers .env nécessaires (secrets via Vault).

- `monitoring` : déploie la stack Prometheus/Grafana/Alertmanager/Blackbox en Docker Compose.

- `nextcloud` : prépare la configuration Apache et LDAPS pour Nextcloud en conteneur.

- `easy_rsa` / `easy_rsa_certs` : PKI (CA) + génération de certificats LDAPS et internes (Nextcloud/Wazuh).

- `distribute_ca` : déploie ca.crt dans le trust store des hôtes Linux.

- `wazuh_server_config` : déploie les configurations Wazuh (indexer/manager/dashboard) + rsyslog receiver.

- `Socle commun` : host, users, ssh_hardening, netplan, ufw_firewall, packages, node_exporter, process_exporter.

- `fail2ban` : Fail2ban sur web01 avec filtres Nginx et action Cloudflare personnalisée.

## Sécurité & secrets

Les secrets sont stockés via Ansible Vault (ex: group_vars/all/vault.yml, host_vars/*/vault.yml).
​
Exemples de secrets mentionnés : token Cloudflare (tunnel), token Cloudflare pour Fail2ban, secrets de webapp (APP_SECRET / credentials DB) et secrets Wazuh (cluster key, API key, mot de passe API dashboard).