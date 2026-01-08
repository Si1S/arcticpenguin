# Rôle — packages

Installe des paquets APT depuis `apt_packages` (avec option de règle UFW sortante temporaire 80/443).

## Variables

- `apt_packages`.

## Utilisation

Inclus dans `playbooks/common.yml`.

Exécuter uniquement ce rôle via le tag :
```bash
ansible-playbook playbooks/common.yml -K -t hostname
