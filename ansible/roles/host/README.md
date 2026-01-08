# Rôle - host

Configure le hostname et met à jour `/etc/hosts` pour cohérence locale.

## Utilisation

Inclus dans `playbooks/common.yml`.

Exécuter uniquement ce rôle via le tag :
```bash
ansible-playbook playbooks/common.yml -K -t packages

