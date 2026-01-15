# 🧱 Ansible - ArcticPenguin

Ce dépôt Ansible automatise le déploiement et le durcissement d’une infra Linux et de plusieurs services (PKI Easy-RSA, distribution de CA, monitoring, exporters, Cloudflare Tunnel, Nextcloud, applications, configuration Wazuh et stack web).

## Contenu

|                                                        |                                                 |
| ------------------------------------------------------ | ----------------------------------------------- |
| 🧱 Socle commun (users, SSH, netplan, UFW, paquets,..) | 🔐 PKI (Easy-RSA, CA, distribution certificats) |
| 📈 Monitoring (Prometheus, Grafana, Alertmanager)      | 📦 Exporters (node_exporter, process_exporter)  |
| 🌐 Cloudflare Tunnel                                   | ☁️ Nextcloud (config, LDAPS)                    |
| 🛡️ Wazuh Manager (configs)                             | 🔎 Wazuh Agents (configs)                       |
| 🚫 Fail2ban (jails, filtres, actions)                  | 🌍 Stack web                                    |

## Prérequis

- Ansible + accès SSH aux hôtes.
- Collections : `community.docker` et `community.general` (voir `collections/requirements.yml`).
- Secrets via Ansible Vault (`group_vars/all/vault.yml`, `host_vars/*/vault.yml`).

## Inventaire & variables

- Inventaire : `inventory.yml` (groupes `linux_servers` / `linux_desktops`).
- Variables globales : `group_vars/all/*.yml`.
- Variables par hôte : `host_vars/<host>.yml`.

## Playbooks

- `playbooks/common.yml` : socle commun (host/users/ssh_hardening/netplan/ufw_firewall/packages/node_exporter/process_exporter).
- `playbooks/pki.yml` : déploie la PKI (Easy-RSA).
- `playbooks/certificates.yml` : génère les certificats LDAPS + internes et récupère les artefacts dans `.certificates/`.
- `playbooks/distributeca.yml` : installe `ca.crt` dans le trust store système.
- `playbooks/nextcloud.yml` : déploie les configurations Nextcloud sur `nxc01`.
- `playbooks/monitoring.yml` : stack monitoring sur `mon01`.
- `playbooks/exporters.yml` : exporters (sauf `mon01` et `arc01`).
- `playbooks/wazuh_server.yml` : déploie les configurations Wazuh sur `waz01`.
- `playbooks/wazuh-agents.yml` : déploie la configuration de l'agent Wazuh.
- `playbooks/cloudflaretunnel.yml` : Cloudflare Tunnel sur `web01`.
- `playbooks/webapp.yml` : déploie la webapp sur `web01`.
- `playbooks/fail2ban.yml` : déploie fail2ban sur `web01`.

## Documentation des rôles

Chaque rôle dispose de son propre README.md.

Exemples :
- 🌍 Webapp : [roles/webapp/README.md](roles/webapp/README.md)
- 📈 Monitoring : [roles/monitoring/README.md](roles/monitoring/README.md)
- 🚫 Fail2ban : [roles/fail2ban/README.md](roles/fail2ban/README.md)

## Commandes

Installer les collections :
```bash
ansible-galaxy collection install -r collections/requirements.yml
```

Dry-run (check + diff) :

```bash
ansible-playbook -i inventory.yml playbooks/common.yml -KCD
```

Exécuter le socle commun :

```bash
ansible-playbook -i inventory.yml playbooks/common.yml -K
```
