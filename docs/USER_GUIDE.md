# Manuel Utilisateur - SarraGStock

Bienvenue dans le manuel d'utilisation de **SarraGStock**. 
Ce guide vous explique comment utiliser l'application au quotidien pour gérer vos stocks, vos ventes et vos clients.

## 📋 Table des matières
1. [Connexion à l'application](#1-connexion-à-lapplication)
2. [Le Tableau de bord](#2-le-tableau-de-bord)
3. [Gestion des Articles (Catalogue)](#3-gestion-des-articles-catalogue)
4. [Gestion des Tiers (Clients & Fournisseurs)](#4-gestion-des-tiers-clients--fournisseurs)
5. [Enregistrer une Vente](#5-enregistrer-une-vente)
6. [Gérer les Achats (Entrées de stock)](#6-gérer-les-achats-entrées-de-stock)
7. [Gérer les Sorties de Stock (Pertes, Casses, etc.)](#7-gérer-les-sorties-de-stock-pertes-casses-etc)
8. [Consulter l'Inventaire](#8-consulter-linventaire)

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

## 4. Gestion des Tiers (Clients & Fournisseurs)

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

## 5. Enregistrer une Vente

C'est l'action la plus courante. Voici comment facturer un client :

1. Allez dans **Ventes > Nouvelle Vente**.
2. **Sélectionnez le client** dans la liste déroulante.
3. **Ajoutez des articles** : Cherchez l'article, choisissez la quantité, et cliquez sur "Ajouter". Répétez l'opération pour chaque produit.
4. **Vérifiez le total** : L'application calcule automatiquement le total. Vous pouvez appliquer une remise si nécessaire.
5. **Choisissez le mode de paiement** (Espèces, Bankily, Crédit, etc.).
6. Cliquez sur **Valider la vente**.

*Le stock de l'article est automatiquement diminué. Vous pouvez imprimer la facture ou l'exporter en PDF depuis la liste des ventes.*

---

## 6. Gérer les Achats (Entrées de stock)

Lorsque vous recevez de la marchandise d'un fournisseur, vous devez l'enregistrer pour mettre à jour votre stock.

1. Allez dans **Achats > Nouvelle Entrée** (ou Commandes).
2. Sélectionnez le **Fournisseur**.
3. Ajoutez les articles reçus et les quantités.
4. Validez l'entrée.

*Le stock est automatiquement incrémenté.*

---

## 7. Gérer les Sorties de Stock (Pertes, Casses, etc.)

Il arrive que des articles quittent le stock **sans être vendus**. Par exemple : un produit périmé, de la casse lors du transport, ou un vol. Il ne faut pas utiliser l'écran "Vente" pour cela (car cela fausserait votre chiffre d'affaires). Utilisez la fonction "Sortie".

1. Allez dans **Stocks > Nouvelle Sortie** (ou Sorties de stock).
2. **Sélectionnez l'article** concerné.
3. Indiquez la **quantité** perdue ou sortie.
4. **Le Motif de sortie** : C'est le champ le plus important. Choisissez le motif approprié dans la liste (ex: *Perte*, *Casse*, *Péremption*, *Don*, etc.).
5. Validez la sortie.

*Le stock est automatiquement diminué, et cette opération sera visible dans l'historique pour votre comptabilité.*

---

## 8. Consulter l'Inventaire

Le menu **Inventaire** vous permet de voir l'état exact de votre stock à un instant T.
- Vous pouvez filtrer par article ou par catégorie.
- L'application met en évidence les articles dont la quantité est inférieure au seuil minimum (en rouge).

---

💡 **Conseil :** Pensez à vérifier régulièrement votre tableau de bord et à mettre à jour vos seuils d'alerte pour ne jamais être en rupture de stock !