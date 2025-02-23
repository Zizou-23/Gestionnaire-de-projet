# Gestionnaire de Projet Collaboratif

Une application web de gestion de projets collaboratifs développée avec Laravel 11. Cette application permet aux utilisateurs d'organiser des projets, de créer et gérer des tâches, d'ajouter des membres aux projets avec des rôles définis (admin ou membre), d'uploader des fichiers, d'envoyer des notifications par e-mail et en temps réel (via Laravel Echo), et bien plus encore.

## Table des Matières

- [Fonctionnalités](#fonctionnalités)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Développement et Contribution](#développement-et-contribution)
- [Licence](#licence)

## Fonctionnalités

- **Gestion des Projets**
  - Création, modification et suppression de projets.
  - Invitation d'utilisateurs à rejoindre un projet (via e-mail ou ajout direct).
  - Affichage des membres du projet et de leurs rôles.
- **Gestion des Tâches**
  - Création, modification et suppression de tâches associées à un projet.
  - Attribution d'une tâche à un membre du projet.
  - Liste des tâches regroupées par projet.
- **Gestion des Fichiers**
  - Upload de fichiers liés aux tâches.
  - Affichage de la liste des fichiers uploadés avec indication de l'auteur et de l'heure d'upload.
  - Possibilité de télécharger les fichiers.
- **Notifications**
  - Envoi d’e-mails lors de l'assignation d'une tâche ou quand une tâche arrive à échéance.
  - Notifications en temps réel via Laravel Echo pour les mises à jour de statut des tâches.
- **Interface Moderne**
  - Utilisation de Laravel Breeze pour l’authentification.
  - Interface responsive grâce à Tailwind CSS et Alpine.js.
  - Layout global incluant un header et un footer personnalisés, avec image de fond et overlay ajusté pour une meilleure lisibilité.

## Prérequis

- **PHP** : Version 8.3 ou supérieure
- **Composer** : Gestionnaire de dépendances PHP
- **Node.js & npm** : Pour compiler les assets avec Vite
- **MySQL** (ou autre SGBD compatible) pour la base de données

## Installation

1. **Cloner le dépôt depuis GitHub**

   ```bash
   git clone https://github.com/votre-utilisateur/gestionnaire-de-projet.git
   cd gestionnaire-de-projet
2.**Installer les dépendances PHP**

bash
composer install

3.**Installer les dépendances Node.js**
bash
npm install

4.**Compiler les assets**
Pour le développement, utilisez :
bash
npm run dev

Pour une compilation en production :
bash
npm run build


5.**Copier le fichier d'environnement**
bash
cp .env.example .env

6.**Générer la clé d'application**
bash
php artisan key:generate

7.**Exécuter les migrations**
bash
php artisan migrate


**Configuration**
Modifiez votre fichier .env pour configurer la connexion à la base de données et le service de messagerie. Par exemple, pour utiliser Gmail (ou un service alternatif si vous utilisez Workspace) :

**env**
# .env
APP_NAME="Gestionnaire de Projet"
APP_ENV=local
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXX
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestionnaire_projet
DB_USERNAME=root
DB_PASSWORD=

# Pour Gmail, si votre compte permet l'utilisation d'un mot de passe d'application (sinon, utilisez Mailtrap ou Sendinblue)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=zikobe6@gmail.com
MAIL_PASSWORD=VotreMotDePasseDApplicationOuCléAPI
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=zikobe6@gmail.com
MAIL_FROM_NAME="Gestionnaire de Projet Version 1K"

# BROADCASTER & PUSHER configuration pour Laravel Echo (si nécessaire)
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=your_pusher_app_cluster
Note :
Si vous ne pouvez pas générer de mot de passe d'application avec Gmail (compte Workspace), envisagez d'utiliser un fournisseur SMTP alternatif gratuit (Mailtrap, Sendinblue, Mailgun, etc.).

Utilisation
Démarrer le serveur local

bash

php artisan serve

Accéder à l'application

Ouvrez http://127.0.0.1:8000 dans votre navigateur.

Authentification

Utilisez Laravel Breeze pour l'inscription et la connexion.
Une fois connecté, vous accéderez à un tableau de bord affichant les projets que vous avez créés et ceux auxquels vous participez.

## Fonctionnalités de projet et tâches

Créez un nouveau projet.
Invitez des utilisateurs au projet (soit par e-mail, soit directement via l'ajout).
Ajoutez et gérez des tâches associées à vos projets.
Associez des fichiers aux tâches et consultez la liste des fichiers uploadés.


Notifications

Lorsqu'une tâche est assignée ou arrive à échéance, des e-mails et des notifications en temps réel sont envoyés.
Les notifications en temps réel nécessitent la configuration de Laravel Echo et Pusher (ou une alternative).
Développement et Contribution(Cette fonctionnalité n'est malheureusement pas encore totalement implémenté)


Structure du projet :

Les vues se trouvent dans le dossier resources/views.
Les composants partagés (header, footer, layout) sont dans resources/views/layout ou resources/views/components.
Les contrôleurs se trouvent dans app/Http/Controllers.
Les modèles se trouvent dans app/Models.
Les notifications se trouvent dans app/Notifications.

Exécution des tests :
Vous pouvez lancer vos tests (si vous en avez) avec :

php artisan test
