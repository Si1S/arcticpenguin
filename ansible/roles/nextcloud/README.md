# Rôle - nextcloud

Prépare les fichiers de configuration Apache (HTTP/HTTPS) et LDAPS pour un déploiement Nextcloud en conteneur.

## Utilisation

Utilisé par `playbooks/nextcloud.yml` (cible `nxc01`).

```bash
ansible-playbook playbooks/nextcloud.yml -K
