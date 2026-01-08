# Nextcloud
## À propos de Nextcloud

Nextcloud est une plateforme de stockage et de partage de fichiers auto-hébergée. Elle permet la synchronisation de fichiers, le partage sécurisé, la gestion de calendriers et de contacts, ainsi que la collaboration en temps réel. Avec son écosystème d'applications extensible et son accent sur la confidentialité, Nextcloud offre un contrôle total sur vos données personnelles et professionnelles.

## Fonctionnalités

| | |
|---|---|
| 📁 Synchronisation et partage de fichiers | 📝 Édition collaborative de documents |
| 🔒 Chiffrement de bout en bout | 🔐 Authentification à deux facteurs |
| 📧 Mail, calendrier et contacts | 🔌 Écosystème d'applications étendu |
| 💬 Chat et appels vidéo | 🔄 Contrôle de version des fichiers |

## Installation avec Docker

La configuration que nous avons préparée part de l'image Docker officielle. Nous avons ajouté LDAP sur cette image et l'avons mise à disposition sur Docker Hub. Docker Compose utilise cette image pour lancer le conteneur avec la configuration locale pour Nextcloud et Apache avec SSL.

La configuration des mots de passe et le choix de la base de données se font une fois que Nextcloud est démarré, mais il est possible de mettre ces paramètres dans les fichiers de configuration.
