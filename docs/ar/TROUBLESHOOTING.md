# Guide de Dépannage - SarraGStock

Ce guide regroupe les problèmes les plus fréquents rencontrés lors de l'utilisation ou du déploiement de l'application, ainsi que les solutions pour les résoudre.

## 📋 Table des matières
1. [Problèmes de Base de Données (MariaDB)](#1-problèmes-de-base-de-données-mariadb)
2. [Problèmes d'Accès et de Connexion](#2-problèmes-daccès-et-de-connexion)
3. [Problèmes de Licence](#3-problèmes-de-licence)
4. [Problèmes lors du Déploiement (deploy.ps1)](#4-problèmes-lors-du-déploiement-deployps1)
5. [Problèmes de Cache Laravel](#5-problèmes-de-cache-laravel)

---

## 1. Problèmes de Base de Données (MariaDB)

### ❌ Erreur : `SQLSTATE[HY000] [2002] Aucune connexion n'a pu être établie...`
**Cause** : L'application n'arrive pas à joindre le serveur de base de données portable.
**Solution** :
1. Vérifiez que MariaDB est bien démarré. Ouvrez un terminal PowerShell et tapez :
   `netstat -ano | findstr :3312`
2. Si aucune ligne n'apparaît, MariaDB ne tourne pas. Lancez-le manuellement :
   `C:\SarraGstock\mariadb\bin\mysqld.exe --datadir="C:\SarraGstock\mariadb\data" --port=3312 --ssl=0`
3. Si MariaDB démarre puis s'arrête, c'est probablement que le port 3312 est occupé par un autre programme. Utilisez la commande `netstat` pour trouver le PID (Process ID) et tuez-le :
   `Stop-Process -Id <PID> -Force`

### ❌ Erreur : Les fichiers de la base de données sont verrouillés (impossible de faire un ZIP)
**Cause** : Le serveur MariaDB (`mysqld.exe`) est en cours d'exécution et verrouille les fichiers (`.ibd`, `.log`, etc.).
**Solution** :
1. Arrêtez proprement MariaDB via le script `stop.bat`.
2. Ou, dans un terminal, utilisez la commande :
   `C:\SarraGstock\mariadb\bin\mysqladmin.exe -u root -P 3312 shutdown`
3. Vérifiez que le processus est mort avec `netstat -ano | findstr :3312` (doit être vide).
4. Vous pouvez maintenant compresser le dossier sans erreur.

---

## 2. Problèmes d'Accès et de Connexion

### ❌ Erreur : Accès refusé (403 Forbidden) après un nouveau déploiement
**Cause** : Votre navigateur/phpDesktop utilise une ancienne "Session" qui pointe vers un ID utilisateur qui n'existe plus (car la base a été réinitialisée). C'est le problème le plus courant !
**Solution** :
1. Déconnectez-vous (si possible).
2. Videz la table des sessions dans la base de données portable. Ouvrez un terminal et tapez :
   `C:\SarraGstock\mariadb\bin\mysql.exe -u root -P 3312 gestock1 -e "TRUNCATE TABLE sessions;"`
3. Reconnectez-vous avec les identifiants par défaut (`superadmin@test.com` / `password`).

### ❌ Erreur : `Unable to flush cache` (Spatie Permission)
**Cause** : Le package de gestion des rôles cherche à vider une clé de cache qui n'existe pas (ou utilise un mauvais driver).
**Solution** : C'est une erreur cosmétique (sans gravité). Utilisez la commande standard de Laravel à la place :
`php artisan optimize:clear`

---

## 3. Problèmes de Licence

### ❌ Le message "Licence invalide" s'affiche alors que la clé est correcte
**Cause** : L'empreinte de la machine (`machine_hash`) a changé (changement de matériel, réinstallation de Windows) ou le fichier de configuration a été altéré.
**Solution** :
1. Vérifiez que le fichier `.env` de la version portable contient bien une clé `APP_KEY` valide.
2. Si vous avez changé de PC, vous devez générer une nouvelle licence. Lancez :
   `php artisan db:seed --class=LicenseSeeder`
3. Récupérez la nouvelle clé générée dans le fichier `C:\SarraGstock\licence\license_key.txt`.

---

## 4. Problèmes lors du Déploiement (deploy.ps1)

### ❌ Le script PowerShell s'arrête avec une erreur rouge
**Cause** : Droits insuffisants ou fichier verrouillé.
**Solution** :
1. Assurez-vous d'exécuter PowerShell **en tant qu'Administrateur** (Clic droit > Exécuter en tant qu'administrateur).
2. Assurez-vous qu'aucune fenêtre de l'application ou de MariaDB n'est ouverte avant de lancer le script.

### ❌ Le script tourne mais la copie sur la clé USB est extrêmement lente
**Cause** : La clé USB doit copier des milliers de petits fichiers (dans le dossier `vendor` de Laravel et `mariadb`). Les clés USB sont très lentes pour ce type de tâche.
**Solution** :
1. **Recommandé** : Arrêtez MariaDB, puis compressez le dossier `C:\SarraGstock` en un seul fichier `.zip` ou `.rar`. Copiez cette archive sur la clé USB. Extrayez-la sur le PC de production.
2. **Alternative** : Modifiez le script `deploy.ps1` pour ajouter l'option `/MT:32` à la fin des commandes `robocopy` (cela utilise 32 threads pour accélérer la copie).

---

## 5. Problèmes de Cache Laravel

### ❌ L'application affiche une page blanche ou une erreur de classe introuvable après une mise à jour
**Cause** : Laravel utilise encore les anciens fichiers en cache (config, routes, vues).
**Solution** :
Dans le dossier de l'application (`C:\SarraGstock\phpdesktop\www`), exécutez :
`php artisan optimize:clear`
`composer dump-autoload`