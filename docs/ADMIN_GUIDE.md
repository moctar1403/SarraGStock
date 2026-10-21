# Manuel Administrateur - SarraGStock

Ce guide est destiné aux administrateurs système de **SarraGStock**. 
Il explique comment gérer les accès (utilisateurs et rôles), surveiller l'activité de l'application et effectuer les sauvegardes de sécurité.

## 📋 Table des matières
1. [Gestion des Utilisateurs](#1-gestion-des-utilisateurs)
2. [Gestion des Rôles et Permissions](#2-gestion-des-rôles-et-permissions)
3. [Surveillance et Traçabilité](#3-surveillance-et-traçabilité)
4. [Sauvegarde et Restauration de la Base de Données](#4-sauvegarde-et-restauration-de-la-base-de-données)

---

## 1. Gestion des Utilisateurs

L'application permet de créer un compte pour chaque employé. Chaque utilisateur doit avoir son propre compte pour que la traçabilité (journal des actions) soit fiable.

### Créer un nouvel utilisateur
1. Allez dans **Configurations > Utilisateurs**.
2. Cliquez sur **Nouvel Utilisateur**.
3. Remplissez le nom, l'adresse e-mail et définissez un mot de passe sécurisé.
4. Assignez-lui un **Rôle** (voir section suivante).
5. Cliquez sur **Enregistrer**.

### Désactiver ou Supprimer un utilisateur
Si un employé quitte l'entreprise, il est impératif de lui retirer ses accès :
- Allez dans la liste des utilisateurs.
- Cliquez sur l'icône de modification.
- Vous pouvez soit changer son mot de passe, soit **supprimer** le compte (icône corbeille).

---

## 2. Gestion des Rôles et Permissions

SarraGStock utilise un système de contrôle d'accès basé sur les rôles (RBAC). Chaque rôle possède un ensemble de permissions spécifiques.

### Les rôles par défaut
- **Super Admin** : A un accès total à toutes les fonctionnalités, y compris la suppression des rôles et permissions. (À réserver au gérant ou à l'informaticien).
- **Admin** : A un accès quasi total, mais ne peut pas supprimer les rôles et permissions critiques.
- **Manager de ventes** : Accès aux articles, ventes, clients, et statistiques.
- **Comptable** : Accès en lecture au tableau de bord pour le suivi financier.
- **Directeur observateur** : Accès en lecture à la plupart des modules pour supervision.

### Créer un rôle personnalisé
1. Allez dans **Configurations > Rôles**.
2. Cliquez sur **Nouveau Rôle** et donnez-lui un nom (ex: "Magasinier").
3. Cochez les permissions correspondantes (ex: *view article, create entree, view inventaire*).
4. Enregistrez.

### Modifier les permissions d'un rôle
Vous pouvez à tout moment modifier la matrice des droits. Allez dans **Rôles**, cliquez sur **Modifier** à côté du rôle souhaité, et cochez/décochez les permissions.

---

## 3. Surveillance et Traçabilité

Pour garantir la sécurité de vos données, l'application enregistre toutes les actions importantes.

### Le journal des Traces
Le menu **Configurations > Traces** vous montre l'historique des actions effectuées dans l'application.
- Vous pouvez voir **qui** a fait **quoi** et **à quelle heure** (ex: "L'utilisateur X a modifié l'article Y").
- Cela permet de détecter les erreurs ou les comportements suspects.

---

## 4. Sauvegarde et Restauration de la Base de Données

⚠️ **Attention** : La base de données contient toutes les informations de votre entreprise (ventes, stocks, clients). Il est vital de la sauvegarder régulièrement.

### Où se trouve la base de données ?
Dans l'environnement portable (production), la base de données est gérée par MariaDB portable et se trouve dans le dossier :
`C:\SarraGstock\mariadb\data\gestock1`

### Comment faire une sauvegarde manuelle (Recommandé)
1. Fermez l'application SarraGStock (ou arrêtez MariaDB avec le script `stop.bat`).
2. Ouvrez le dossier `C:\SarraGstock\sql`.
3. Le script de déploiement y place automatiquement une sauvegarde à chaque déploiement.
4. **Copiez le fichier `.sql` le plus récent** sur une clé USB ou un disque externe.

### Comment restaurer une sauvegarde en cas de problème
Si l'application crash ou si les données sont corrompues :
1. Arrêtez MariaDB.
2. Remplacez le dossier `C:\SarraGstock\mariadb\data\gestock1` par une ancienne version sauvegardée.
3. OU utilisez le script `deploy.ps1` en plaçant votre fichier `.sql` dans le dossier `C:\SarraGstock\sql` (le script importera ce fichier lors du déploiement).

💡 **Règle d'or** : Sauvegardez la base de données sur un support externe (clé USB, Cloud) **au moins une fois par semaine**.