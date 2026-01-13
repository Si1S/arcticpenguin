# Rôle - wazuh_server_config

Ce rôle déploie les fichiers de configuration nécessaires au serveur Wazuh (indexer + manager + dashboard) ainsi que la réception des logs du firewall via rsyslog.

## Ce que fait le rôle

- Copie les fichiers de configuration Wazuh (indexer, filebeat, manager, dashboard) et tes fichiers custom (rules/decoders/agent.conf).
- Déploie la conf rsyslog /etc/rsyslog.d/10-receiver.conf.
- Redémarre les services concernés quand un fichier change.

## Variables Vault

Certaines variables doivent être stockées dans un fichier chiffré Ansible Vault (ex: host_vars/waz01.vault.yml).

Variables sensibles utilisées :
- `wazuh_mgr_cluster_key`
- `wazuh_mgr_virustotal_api_key`
- `wazuh_dash_api_password`

## Utilisation

Utilisé par `playbooks/wazuh_server.yml` (cible `waz01`).

```bash
ansible-playbook playbooks/wazuh_server.yml -K
