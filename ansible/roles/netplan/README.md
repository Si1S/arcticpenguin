# Rôle — netplan

Génère `/etc/netplan/01-config.yaml` et applique la configuration réseau.


## Utilisation

Inclus dans `playbooks/common.yml`.

Exécuter uniquement ce rôle via le tag :
```bash
ansible-playbook playbooks/common.yml -K -t network
