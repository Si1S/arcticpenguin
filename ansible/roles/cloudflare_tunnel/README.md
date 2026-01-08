# Rôle — cloudflare_tunnel

Installe et configure `cloudflared` (tunnel Cloudflare) + service systemd.

## Variables

- `cloudflared_tunnel_token` (Vault), `cloudflared_hostname`, `cloudflared_service_url`.

## Utilisation

Utilisé par `playbooks/cloudflare_tunnel.yml` (cible `web01`).

```bash
ansible-playbook playbooks/cloudflare_tunnel.yml -K
