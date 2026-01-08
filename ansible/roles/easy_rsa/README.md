# Rôle — easy_rsa

Easy-RSA est un utilitaire en ligne de commande qui permet de créer et gérer une PKI (infrastructure à clés publiques), notamment en mettant en place une **autorité de certification** (CA) et en signant des certificats.

## Ce que fait le rôle

- Installe Easy-RSA et ses dépendances, puis initialise le répertoire PKI.
- Génère une autorité de certification (CA) non-interactive (`build-ca`) afin de produire le certificat racine (`ca.crt`) et la clé de CA. 

## Utilisation

Utilisé par `playbooks/pki.yml` (cible `pki01`).

```bash
ansible-playbook playbooks/pki.yml -K
