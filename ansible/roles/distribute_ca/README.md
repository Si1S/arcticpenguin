# Rôle — distribute_ca

Ce rôle distribue et installe le certificat racine de la PKI (le fichier `ca.crt`) dans le magasin de certificats **système** des hôtes Linux, afin que les services et clients de la machine fassent confiance aux certificats émis par l'autorité de certification.

## Ce que fait le rôle

- Détermine automatiquement le bon chemin d’installation selon la famille d’OS (Debian/RedHat) et crée le répertoire si besoin.
- Copie `ca.crt` sur l’hôte, déclenche la commande de mise à jour du trust store (`update-ca-certificates` ou `update-ca-trust`) et vérifie que le certificat est lisible via `openssl`.

## Utilisation

Utilisé par `playbooks/distribute_ca.yml` (cible `all!windows!pki01`) avec des post-tasks de vérification dans le bundle CA système.

```bash
ansible-playbook playbooks/distribute_ca.yml -K
