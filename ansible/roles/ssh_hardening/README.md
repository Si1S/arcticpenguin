# Rôle - ssh_hardening

Déploie une configuration `sshd` durcie depuis template et redémarre le service SSH.

## Utilisation

Inclus dans `playbooks/common.yml`.

Exécuter uniquement ce rôle via le tag :
```bash
ansible-playbook playbooks/common.yml -K -t ssh

