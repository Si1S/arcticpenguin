# Rôle - wazuh_client_config

Déploie une configuration de l'agent Wazuh et redémarre le service wazuh-agent uniquement si le fichier change.

## Ce que fait le rôle

- Déploie le fichier `/var/ossec/etc/ossec.conf` depuis un template.
- Ajoute des sources de logs supplémentaires via des blocs `<localfile>` (ex: NGINX ou Nextcloud) selon les variables d’hôte.
- Redémarre wazuh-agent uniquement si le fichier de configuration a changé (via handler Ansible).
- Active le bloc `<wodle name="docker-listener">` si `wazuh_enable_docker_listener: true`.

## Utilisation

Ce rôle est utilisé par `playbooks/wazuh-agents.yml`.

```bash
ansible-playbook playbooks/wazuh-agents.yml -K
