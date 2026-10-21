# Manuel Administrateur - SarraGStock

Ce guide est destiné aux administrateurs système de **SarraGStock**. 
Il explique comment gérer les accès, configurer l'application, surveiller l'activité et effectuer les sauvegardes de sécurité.

## 📋 Table des matières
1. [Gestion des Utilisateurs](#1-gestion-des-utilisateurs)
2. [Gestion des Rôles et Permissions](#2-gestion-des-rôles-et-permissions)
3. [Configuration de l'Application](#3-configuration-de-lapplication)
4. [Surveillance et Traçabilité](#4-surveillance-et-traçabilité)
5. [Sauvegarde et Restauration de la Base de Données](#5-sauvegarde-et-restauration-de-la-base-de-données)

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

## 3. Configuration de l'Application

Le menu **Configurations** regroupe tous les paramètres pour adapter l'application à votre entreprise.

### 3.1. Méthodes de paiement
Gérez les moyens par lesquels vos clients vous paient.
1. Allez dans **Configurations > Méthodes de paiement**.
2. Vous pouvez ajouter de nouvelles méthodes (ex: Espèces, Bankily, Masrivi, Sedad, Clic, BIM BANK, etc.).
3. Ces méthodes apparaîtront dans les listes déroulantes lors de l'enregistrement d'une vente ou d'un paiement.

### 3.2. Informations de la Société
Permet de personnaliser les documents générés par l'application (comme les factures).
1. Allez dans **Configurations > Société**.
2. Remplissez le nom de votre entreprise, l'adresse, le téléphone, l'e-mail, le NIF et le RC.
3. Vous pouvez également uploader le logo de l'entreprise. Ces informations apparaîtront sur les factures imprimées.

### 3.3. Monnaies
Configurez la devise principale utilisée par l'application.
1. Allez dans **Configurations > Monnaies**.
2. Vous pouvez définir la monnaie active (ex: MRU - Ouguiya). 
3. L'application supporte plusieurs monnaies, mais une seule est active à la fois pour les transactions courantes.

### 3.4. Unités de vente
Définissez comment vos articles sont mesurés.
1. Allez dans **Configurations > Unités de vente**.
2. Gérez les unités de base (ex: Unité, Kilogramme, Litre, Mètre).
3. Vous pouvez également configurer des sous-unités (ex: Gramme pour le Kilogramme) pour plus de précision dans la gestion des stocks.

### 3.5. Langue
Permet de changer la langue de l'interface de l'application (selon les langues disponibles).
1. Allez dans **Configurations > Langue**.
2. Sélectionnez la langue de votre choix. L'interface se mettra à jour.

### 3.6. Valorisation des Stocks (CUMP, DEPS, PEPS)
Ce paramètre est **critique** car il détermine comment l'application calcule la valeur de votre stock et le coût de revient de vos articles (méthode comptable).
1. Allez dans **Configurations > Stock**.
2. Choisissez la méthode de valorisation :
   - **CUMP (Coût Unitaire Moyen Pondéré)** : Le coût est recalculé à chaque nouvelle entrée en fonction du prix moyen. C'est la méthode la plus courante et recommandée.
   - **PEPS (Premier Entré, Premier Sorti / FIFO)** : Les premiers articles achetés sont considérés comme les premiers vendus.
   - **DEPS (Dernier Entré, Premier Sorti / LIFO)** : Les derniers articles achetés sont considérés comme les premiers vendus.
3. Une fois la méthode choisie et validée, elle s'appliquera au calcul de vos marges et à la valeur de votre inventaire.

---

## 4. Surveillance et Traçabilité

Pour garantir la sécurité de vos données, l'application enregistre toutes les actions importantes.

### Le journal des Traces
Le menu **Configurations > Traces** vous montre l'historique des actions effectuées dans l'application.
- Vous pouvez voir **qui** a fait **quoi** et **à quelle heure** (ex: "L'utilisateur X a modifié l'article Y").
- Cela permet de détecter les erreurs ou les comportements suspects.

---

## 5. Sauvegarde et Restauration de la Base de Données

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