# SarraGStock - Gestion de Stock

Application de gestion de stock et de facturation, développée avec Laravel et Livewire. 
Elle est conçue pour être déployée en local (portable) via PHPDesktop et MariaDB portable, sans nécessiter l'installation d'un serveur web classique.

## 🚀 Fonctionnalités

- **Gestion des articles** : Ajout, modification, suppression, gestion des stocks et des seuils d'alerte.
- **Gestion des tiers** : Clients et fournisseurs.
- **Ventes et Factures** : Création de factures, gestion des remises, impression et export PDF.
- **Achats et Approvisionnements** : Fournisseurs, entrées et sorties de stock.
- **Trésorerie** : Suivi des paiements (clients et fournisseurs), gestion des méthodes de paiement (Espèces, Bankily, etc.).
- **Inventaire** : Ajustements de stock et historique.
- **Sécurité et Rôles** : Gestion des utilisateurs, des rôles et des permissions (basé sur `spatie/laravel-permission`).
- **Licence** : Système d'activation par clé de licence.
- **Traçabilité** : Journal des actions (traces) et journal d'activité.

## 🏗️ Architecture des dossiers

Le projet repose sur une séparation stricte entre l'environnement de développement et l'environnement portable de production.

### 1. Environnement de développement (WAMP)
- **Chemin** : `C:\wamp64\www\SarraGStock`
- **Rôle** : C'est ici que le code source est développé, testé et versionné avec Git. 
- **Base de données** : Utilise MySQL/MariaDB de WAMP (généralement sur le port 3306).

### 2. Environnement portable (Production)
- **Chemin** : `C:\SarraGstock`
- **Rôle** : C'est le dossier qui sera copié sur la clé USB et déployé sur le PC de production.
- **Contenu** :
  - `deploy.ps1` : Script de déploiement automatisé.
  - `start.bat` / `stop.bat` : Scripts pour démarrer et arrêter l'application.
  - `licence/` : Contient la clé de licence générée.
  - `sql/` : Contient les sauvegardes de la base de données.
  - `mariadb/` : Le serveur de base de données portable.
  - `php/` : L'interpréteur PHP portable.
  - `phpdesktop/` : L'application (interface) et le dossier `www` qui recevra la copie du code source.

**Fonctionnement du déploiement** : Le script `deploy.ps1` va copier le code source depuis `C:\wamp64\www\SarraGStock` vers `C:\SarraGstock\phpdesktop\www`, configurer l'environnement, importer la base de données et générer la licence. Ensuite, l'ensemble du dossier `C:\SarraGstock` est prêt à être copié sur le PC de production.

## 🛠️ Prérequis (Environnement de développement)

- PHP 8.2 ou supérieur
- Composer
- Node.js & NPM
- MySQL ou MariaDB (WAMP/XAMPP)
- Git

## 💻 Installation (Développement)

1. **Cloner le dépôt**
   `git clone <votre-url-git> SarraGStock`
   `cd SarraGStock`

2. **Installer les dépendances PHP**
   `composer install`

3. **Installer les dépendances Frontend**
   `npm install`

4. **Configuration de l'environnement**
   `cp .env.example .env`
   `php artisan key:generate`
   *Modifiez le fichier `.env` avec vos identifiants de base de données locales (port 3306).*

5. **Créer la base de données et lancer les migrations**
   `php artisan migrate`

6. **Peupler la base avec les données de base**
   `php artisan db:seed`
   *(Les seeders vont créer les rôles, permissions, utilisateurs par défaut, monnaies, unités, etc.)*

7. **Compiler les assets (Frontend)**
   `npm run build`

8. **Lancer le serveur de développement**
   `php artisan serve`
   *L'application sera accessible sur `http://127.0.0.1:8000`.*

## 📦 Déploiement (Production Portable)

1. **Préparation**
   - Assurez-vous que le dossier `C:\SarraGstock` contient bien tous les outils portables (`mariadb`, `php`, `phpdesktop`, etc.).
   - Ouvrez un terminal **PowerShell en tant qu'Administrateur**.

2. **Exécution du script**
   `cd C:\SarraGstock`
   `.\deploy.ps1`
   *Le script va :*
   - Sauvegarder la base de données de développement.
   - Compiler les assets (NPM).
   - Copier les fichiers depuis `C:\wamp64\www\SarraGStock` vers `C:\SarraGstock\phpdesktop\www`.
   - Démarrer MariaDB portable sur le port `3312`.
   - Importer la base de données.
   - Configurer le fichier `.env`.
   - Générer une clé de licence.

3. **Lancement de l'application**
   - Utilisez le script `start.bat` ou ouvrez directement `C:\SarraGstock\phpdesktop\phpdesktop-chrome.exe`.

## 🔑 Comptes par défaut (après seed)

- **Super Admin** : `superadmin@test.com` / `password`
- **Admin** : `admin@test.com` / `password`

*(⚠️ Il est impératif de changer ces mots de passe lors de la première connexion en production).*

## 💾 Sauvegarde et Restauration

Pour éviter toute perte de données en cas d'incident sur le PC de développement, il est crucial de sauvegarder trois éléments distincts : **le code**, **les outils portables** et **la base de données**.

### 1. Sauvegarde du Code (Git)
Le code source est versionné avec Git. Pour le sauvegarder sur un dépôt distant (GitHub, GitLab, etc.) :
`git push origin main` (et n'oubliez pas de pousser les tags avec `git push origin --tags`).

### 2. Sauvegarde des Outils Portables (ZIP)
Les dossiers `mariadb`, `php`, et `phpdesktop` ne doivent pas être dans Git (trop lourds). Pour les sauvegarder :
1. Arrêtez l'application et assurez-vous qu'aucun processus `mysqld.exe` ne tourne.
2. Faites un clic droit sur le dossier `C:\SarraGstock` et compressez-le en ZIP (ex: `SarraGstock_Tools_2026-10-21.zip`).
3. Copiez cette archive sur un support externe (clé USB) et/ou sur un Cloud (Google Drive, OneDrive).

### 3. Sauvegarde de la Base de Données (SQL)
Exportez régulièrement votre base de développement (WAMP) via phpMyAdmin (onglet "Exporter" de la base `gestock1`). 
Conservez ces fichiers `.sql` dans un endroit sûr (Cloud ou clé USB).

### 🚑 Que faire en cas de perte totale du PC de développement ?
Si vous devez réinstaller l'environnement sur un nouveau PC, voici la procédure de restauration :
1. **Clonez** votre projet Git (`git clone ...`).
2. **Extrayez** l'archive ZIP des outils portables (pour recréer le dossier `C:\SarraGstock`).
3. **Importez** votre dernier fichier `.sql` dans WAMP (ou dans le dossier `C:\SarraGstock\sql` selon la méthode de restauration choisie).
4. **Lancez** le script `.\deploy.ps1` pour reconstruire l'environnement portable et générer une nouvelle licence.

## 📚 Documentation

La documentation complète est disponible dans le dossier `docs/`.

- [Manuel d'installation (Production)](docs/INSTALLATION.md)
- [Manuel Utilisateur](docs/USER_GUIDE.md)
- [Manuel Administrateur](docs/ADMIN_GUIDE.md)
- [Guide de Dépannage](docs/TROUBLESHOOTING.md)

## 📝 Licence

Ce projet est sous licence propriétaire. Toute reproduction ou distribution sans autorisation est interdite.