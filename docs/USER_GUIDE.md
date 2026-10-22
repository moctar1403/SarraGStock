# Manuel Utilisateur - SarraGStock

Bienvenue dans le manuel d'utilisation de **SarraGStock**. 
Ce guide vous explique comment utiliser l'application au quotidien pour gérer vos stocks, vos ventes et vos clients.

## 📋 Table des matières
1. [Connexion à l'application](#1-connexion-à-lapplication)
2. [Le Tableau de bord](#2-le-tableau-de-bord)
3. [Gestion des Articles (Catalogue)](#3-gestion-des-articles-catalogue)
4. [Détailler un Article (Conditionnement)](#4-détailler-un-article-conditionnement)
5. [Gestion des Tiers (Clients & Fournisseurs)](#5-gestion-des-tiers-clients--fournisseurs)
6. [Enregistrer une Vente](#6-enregistrer-une-vente)
7. [Gérer les Achats (Entrées de stock)](#7-gérer-les-achats-entrées-de-stock)
8. [Gérer les Sorties de Stock (Pertes, Casses, etc.)](#8-gérer-les-sorties-de-stock-pertes-casses-etc)
9. [Consulter l'Inventaire](#9-consulter-linventaire)

---

## 1. Connexion à l'application

1. Lancez l'application en double-cliquant sur l'icône **SarraGStock** (ou via `start.bat`).
2. Saisissez votre adresse e-mail et votre mot de passe.
3. Cliquez sur **Se connecter**.

*Note : Si vous avez oublié votre mot de passe, contactez votre administrateur système.*

---

## 2. Le Tableau de bord

Une fois connecté, vous arrivez sur le **Tableau de bord** (Dashboard). 
Il vous donne un aperçu rapide de l'état de votre stock :
- Les articles en alerte de stock (quantité basse).
- Les dernières ventes.
- Des graphiques sur les performances (selon vos droits d'accès).

Utilisez le **menu de gauche** pour naviguer entre les différentes sections de l'application.

---

## 3. Gestion des Articles (Catalogue)

Le menu **Articles** vous permet de gérer votre catalogue de produits.

### Créer un nouvel article
1. Allez dans **Articles > Liste des articles**.
2. Cliquez sur le bouton **Nouvel Article** (en haut à droite).
3. Remplissez les champs :
   - **Référence** : Le code unique de l'article (ex: ART-001).
   - **Libellé** : Le nom du produit.
   - **Prix d'achat** et **Prix de vente**.
   - **Quantité minimum** : Le seuil d'alerte (l'application vous préviendra si le stock descend en dessous).
   - **Unité** : (ex: Unité, Kilogramme, Litre).
4. Cliquez sur **Enregistrer**.

### Modifier ou Supprimer
Dans la liste des articles, cliquez sur l'icône ✏️ (crayon) pour modifier, ou sur l'icône 🗑️ (corbeille) pour supprimer un article. *(Attention : la suppression est définitive).*

---

## 4. Détailler un Article (Conditionnement)

Certains articles sont achetés et stockés en gros (ex: une caisse de 12 bouteilles d'eau), mais peuvent être vendus à l'unité. La fonction **Détailler un article** permet de gérer ce système de conditionnement.

### A. Créer un article de détail
Avant de pouvoir "casser" une caisse, il faut créer l'article qui représentera l'unité de base.

1. Allez dans **Articles > Nouvel Article**.
2. Remplissez les champs obligatoires (marqués en rouge) :
   - **Libellé Article** : Le nom de l'unité de base (ex: "Bouteille d'eau 1.5L").
   - **Description** : Une courte description.
   - **Prix de vente** : Le prix de vente de l'unité seule.
3. *Optionnel* : Vous pouvez également renseigner la **Référence** et le **Code barre**, mais ce n'est pas obligatoire.
4. ⚠️ **Point crucial :** Dans le champ **Unité de vente**, sélectionnez impérativement **"Article de détail"**.
5. **Quantité** : Laissez à `0` (elle sera gérée automatiquement par les opérations de détail).
6. **Quantité minimale** : Ce champ est obligatoire et doit être renseigné (mettez `0` si vous ne souhaitez pas d'alerte de stock sur l'unité seule).
7. **Ne touchez pas** aux champs *Prix total achat* et *Prix achat* : ils sont grisés et seront calculés automatiquement par l'application lors de l'opération de détail.
8. Cliquez sur **Enregistrer**.

### B. Lier l'article principal à son détail
Maintenant, il faut dire à l'application que "1 Caisse" contient "12 Bouteilles".

1. Allez dans **Articles > Détailler un article > Liste des articles détaillables**.
2. Cliquez sur **Ajouter un article de détail**.
3. **Choisissez l'article principal** (ex: "Caisse d'eau 12x1.5L").
4. **Choisissez l'article de détail** (ex: "Bouteille d'eau 1.5L").
5. Indiquez la **Quantité de l'article détail par unité d'article principal** (ex: tapez `12`).
6. Cliquez sur **Ajouter** pour valider la liaison.

### C. Effectuer une opération de détail (Casser une caisse)
Lorsque vous voulez vendre les bouteilles à l'unité, vous ne pouvez pas le faire directement. Vous devez d'abord "détailler" la caisse dans le système.

1. Allez dans **Articles > Détailler un article > Liste des opérations de détail**.
2. Cliquez sur **Effectuer une opération de détail**.
3. **Sélectionnez l'Article principal** (ex: "Caisse d'eau"). L'application affichera automatiquement l'article de détail lié et la **Quantité Disponible**.
4. Indiquez la **Quantité sortie de l'Article principal** (ex: si vous sortez 2 caisses, tapez `2`).
5. L'application calcule automatiquement la **Quantité Totale entrée** pour l'article de détail (ex: 2 caisses × 12 = 24 bouteilles).
6. Vérifiez les **Prix d'achat** et **Prix de vente** calculés pour l'unité.
7. Choisissez la **Date** de l'opération et validez.

*Résultat : Le stock de la caisse diminue de 2, et le stock des bouteilles individuelles augmente de 24. Vous pouvez maintenant vendre les bouteilles à l'unité !*

---

## 5. Gestion des Tiers (Clients & Fournisseurs)

Le menu **Tiers** regroupe vos clients et vos fournisseurs.

### Ajouter un Client
1. Allez dans **Tiers > Clients**.
2. Cliquez sur **Nouveau Client**.
3. Renseignez les informations (Nom, Société, Téléphone, Adresse, etc.).
4. Cliquez sur **Enregistrer**.

*Vous pouvez suivre la situation financière de chaque client (dettes/crédits) directement depuis leur fiche.*

### Ajouter un Fournisseur
La procédure est identique, mais dans la section **Tiers > Fournisseurs**.

---

## 6. Enregistrer une Vente

C'est l'action la plus courante. Voici comment facturer un client :

1. Allez dans **Ventes > Nouvelle Vente**.
2. **Sélectionnez le client** dans la liste déroulante.
3. **Ajoutez des articles** : Cherchez l'article, choisissez la quantité, et cliquez sur "Ajouter". Répétez l'opération pour chaque produit.
4. **Vérifiez le total** : L'application calcule automatiquement le total. Vous pouvez appliquer une remise si nécessaire.
5. **Choisissez le mode de paiement** (Espèces, Bankily, Crédit, etc.).
6. Cliquez sur **Valider la vente**.

*Le stock de l'article est automatiquement diminué. Vous pouvez imprimer la facture ou l'exporter en PDF depuis la liste des ventes.*

---

## 7. Gérer les Achats (Entrées de stock)

Lorsque vous recevez de la marchandise d'un fournisseur, vous devez l'enregistrer pour mettre à jour votre stock.

1. Allez dans **Achats > Nouvelle Entrée** (ou Commandes).
2. Sélectionnez le **Fournisseur**.
3. Ajoutez les articles reçus et les quantités.
4. Validez l'entrée.

*Le stock est automatiquement incrémenté.*

---

## 8. Gérer les Sorties de Stock (Pertes, Casses, etc.)

Il arrive que des articles quittent le stock **sans être vendus**. Par exemple : un produit périmé, de la casse lors du transport, ou un vol. Il ne faut pas utiliser l'écran "Vente" pour cela (car cela fausserait votre chiffre d'affaires). Utilisez la fonction "Sortie".

1. Allez dans **Stocks > Nouvelle Sortie** (ou Sorties de stock).
2. **Sélectionnez l'article** concerné.
3. Indiquez la **quantité** perdue ou sortie.
4. **Le Motif de sortie** : C'est le champ le plus important. Choisissez le motif approprié dans la liste (ex: *Perte*, *Casse*, *Péremption*, *Don*, etc.).
5. Validez la sortie.

*Le stock est automatiquement diminué, et cette opération sera visible dans l'historique pour votre comptabilité.*

---

## 9. Consulter l'Inventaire

Le menu **Inventaire** vous permet de voir l'état exact de votre stock à un instant T.
- Vous pouvez filtrer par article ou par catégorie.
- L'application met en évidence les articles dont la quantité est inférieure au seuil minimum (en rouge).

---

💡 **Conseil :** Pensez à vérifier régulièrement votre tableau de bord et à mettre à jour vos seuils d'alerte pour ne jamais être en rupture de stock !