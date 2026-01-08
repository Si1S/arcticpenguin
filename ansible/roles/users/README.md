# Rôle — users

Gère les comptes locaux (création, clés SSH, sudo) et peut supprimer les comptes non autorisés (UID >= 1000).

## Variables

- `users` (définition des comptes).
- `default_authorized_users` + `extra_authorized_users` (liste finale autorisée).

## Utilisation

Inclus dans `playbooks/common.yml`.

Exécuter uniquement ce rôle via le tag :
```bash
ansible-playbook playbooks/common.yml -K -t users
