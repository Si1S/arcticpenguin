# Rôle - easy_rsa_certs

Génère des certificats LDAPS (DC) et des certificats internes (Nextcloud et Wazuh) via Easy-RSA.

## Variables

- `ldaps_certificates`, `internal_certs`.

## Utilisation

Utilisé par `playbooks/certificates.yml` (cible `pki01`).

```bash
ansible-playbook playbooks/certificates.yml -K
