# Rôle - ufw_firewall

Applique la politique firewall via UFW.

## Utilisation

Inclus dans `playbooks/common.yml`.

Exécuter uniquement ce rôle via le tag :
```bash
ansible-playbook playbooks/common.yml -K -t firewall
