# Guide d'Installation - SarraGStock

Ce document détaille les procédures d'installation et de déploiement de l'application SarraGStock.

## 📋 Table des matières
1. [Installation en environnement de développement (WAMP)](#1-installation-en-environnement-de-développement-wamp)
2. [Déploiement en environnement de production (Portable)](#2-déploiement-en-environnement-de-production-portable)
3. [Résolution des problèmes courants](#3-résolution-des-problèmes-courants)

---

## 1. Installation en environnement de développement (WAMP)

Cette section explique comment installer le projet sur un PC de développement disposant de WAMP.

### Prérequis
- WAMP Server installé et démarré (PHP 8.2+, MySQL/MariaDB).
- Git installé.
- Composer installé.
- Node.js et NPM installés.

### Étapes d'installation

**1.1. Cloner le projet**
Ouvrez un terminal, placez-vous dans le dossier de WAMP et clonez le dépôt :
`cd C:\wamp64\www`
`git clone <votre-url-git> SarraGStock`
`cd SarraGStock`

**1.2. Installer les dépendances**
`composer install`
`npm install`

**1.3. Configurer l'environnement**
Copiez le fichier d'exemple et générez la clé d'application :
`cp .env.example .env`
`php artisan key:generate`

Ouvrez le fichier `.env` et configurez la connexion à votre base de données WAMP (port 3306 par défaut) :
`DB_CONNECTION=mysql`
`DB_HOST=127.0.0.1`
`DB_PORT=3306`
`DB_DATABASE=gestock1`
`DB_USERNAME=root`
`DB_PASSWORD=`

**1.4. Initialiser la base de données**
Créez la base (si elle n'existe pas via phpMyAdmin), puis lancez les migrations et les seeders :
`php artisan migrate`
`php artisan db:seed`

**1.5. Compiler les assets**
`npm run build`

**1.6. Lancer l'application**
`php artisan serve`
L'application est accessible à l'adresse `http://127.0.0.1:8000`.

---

## 2. Déploiement en environnement de production (Portable)

L'application utilise un système portable (MariaDB + PHP + phpDesktop) pour fonctionner sans installation de serveur web sur le PC cible.

### Prérequis
- Un dossier `C:\SarraGstock` contenant déjà les outils portables (dossier `mariadb`, `php`, `phpdesktop`, etc.).
- Le script `deploy.ps1` placé à la racine de `C:\SarraGstock`.
- PowerShell exécuté en tant qu'Administrateur.

### Procédure de déploiement

**2.1. Préparation**
Assurez-vous que votre code source de développement (`C:\wamp64\www\SarraGStock`) est à jour et fonctionnel.

**2.2. Exécution du script de déploiement**
Ouvrez un terminal PowerShell **en tant qu'Administrateur**, placez-vous dans le dossier portable et lancez le script :
`cd C:\SarraGstock`
`.\deploy.ps1`

**Ce que fait le script automatiquement :**
1. Il se connecte à votre base de données de développement (WAMP, port 3306) pour faire un dump SQL.
2. Il nettoie les caches de Laravel dans le projet de dev.
3. Il compile les assets avec NPM (`npm run build`).
4. Il arrête MariaDB portable s'il tourne déjà.
5. Il copie le code source de `C:\wamp64\www\SarraGStock` vers `C:\SarraGstock\phpdesktop\www`.
6. Il démarre MariaDB portable sur le port `3312`.
7. Il crée la base de données et importe le dump SQL.
8. Il modifie le fichier `.env` de la version portable pour pointer sur le port `3312`.
9. Il génère une nouvelle clé de licence.
10. Il optimise les caches pour la production.

**2.3. Lancement de l'application**
Une fois le script terminé avec succès :
- Lancez `start.bat` (ou ouvrez `C:\SarraGstock\phpdesktop\phpdesktop-chrome.exe`).
- Connectez-vous avec les identifiants par défaut.

**2.4. Transfert vers le PC de production**
Une fois le déploiement terminé, vous pouvez :
- Arrêter MariaDB portable (via `stop.bat` ou en fermant la fenêtre).
- Copier l'intégralité du dossier `C:\SarraGstock` sur une clé USB.
- Coller ce dossier sur le PC de production.
- Lancer `start.bat` sur le PC de production.

---

## 3. Résolution des problèmes courants

| Problème | Cause probable | Solution |
| :--- | :--- | :--- |
| **Erreur SQLSTATE[HY000] [2002]** | MariaDB portable n'est pas démarré. | Vérifiez que le processus `mysqld.exe` tourne (via le Gestionnaire des tâches) ou relancez `start.bat`. |
| **Port 3312 déjà utilisé** | Un autre service utilise le port. | Ouvrez PowerShell : `netstat -ano \| findstr :3312`, puis tuez le processus (PID) avec `Stop-Process -Id <PID> -Force`. |
| **Accès refusé / 403 Forbidden** | Session obsolète après un déploiement. | Videz la table `sessions` dans la base de données portable. |
| **Fichier .env introuvable** | La copie via robocopy a échoué. | Vérifiez les droits d'accès au dossier `C:\SarraGstock\phpdesktop\www`. |
| **La licence n'est pas générée** | Le seeder a échoué. | Vérifiez que `php artisan db:seed --class=LicenseSeeder` fonctionne manuellement dans `C:\SarraGstock\phpdesktop\www`. |