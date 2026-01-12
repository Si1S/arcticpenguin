# Rôle - fail2ban

Ce rôle installe et configure Fail2ban sur `web01`, avec bannissement Cloudflare et filtres personalisés Nginx.

## Ce que fait le rôle

- Ouvre temporairement l’accès **sortant** UFW sur 80/443 pour permettre le téléchargement/installation du paquet (la politique UFW de ce serveur bloque l’outbound).
- Télécharge un paquet Fail2ban .deb depuis GitHub, car sur Ubuntu 24.04 (noble) le paquet fail2ban du dépôt (universe) est en 1.0.2-3 et n'était pas fonctionnel sur notre environnement.
- Déploie la configuration `/etc/fail2ban/jail.local` depuis un template.
- Déploie 3 filtres personnalisés dans `/etc/fail2ban/filter.d/` (`web-scanner`, `nginx-env`, `nginx-4xx-probing`).
- Déploie une action Cloudflare personnalisée dans `/etc/fail2ban/action.d/cloudflare-apiv4.conf`, afin de corriger un problème d’unban côté Cloudflare (l’action par défaut ne supprimait pas correctement les règles, probablement suite à un changement/comportement différent de l’API Cloudflare).
- Active et démarre le service `fail2ban`, et redémarre automatiquement via handler quand une configuration change.

## Dépendances (rôle packages)
Le playbook doit appeler le rôle `packages` avant `fail2ban` pour installer les paquets requis.

## Secrets (Ansible Vault)

Le token Cloudflare est stocké via Ansible Vault dans `host_vars/web01/vault.yml` sous la variable :

- `vault_fail2ban_cf_token`

Exemple (contenu déchiffré) :

```yaml
vault_fail2ban_cf_token: "monsupertoken"
```

## Utilisation

Ce rôle est utilisé par `playbooks/fail2ban.yml` et cible l’hôte `web01`.

```bash
ansible-playbook playbooks/fail2ban.yml -K
```