Configuration unique de la clé de déploiement GitHub pour mon01

1. Générer la clé SSH sur mon01 (utilisateur monitoring) :
   ansible-playbook playbooks/deploy-monitoring.yml -l mon01 --tags ssh-key

   Cette commande :
   - crée la clé SSH ed25519 pour l’utilisateur « monitoring » si elle n’existe pas ;
   - affiche la clé publique dans la sortie Ansible (tâche « Display public SSH key »).

2. Copier la clé publique affichée par Ansible
   (ligne commençant par « ssh-ed25519 » dans la sortie du playbook).

3. Dans GitHub, sur le dépôt « Si1S/arcticpenguin » :
   - Aller dans : Settings → Deploy keys → Add deploy key
   - Title : mon01-monitoring
   - Key : coller la clé publique
   - Cocher « Allow read access »
   - Enregistrer

4. Une fois la clé ajoutée, relancer le playbook complet :
   ansible-playbook playbooks/deploy-monitoring.yml -l mon01

