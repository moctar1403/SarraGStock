# Gérer les Achats (Entrées de stock)

[⬅ Retour au sommaire](/documentation/user_guide)

Le menu **Achats** (ou **Entrées en stock**) vous permet d'enregistrer la réception de marchandises de vos fournisseurs. L'application met automatiquement à jour votre stock, les prix de vos articles et la situation financière de votre fournisseur.

---

## 1. Consulter l'historique des entrées

![Liste des entrées en stock](/images/docs/liste-entrees.png)

L'écran affiche la liste de toutes les réceptions de marchandises :
- **Date** de réception.
- **Article** et **Fournisseur**.
- **Quantité** reçue.
- **Prix Achat** et **Prix Vente** appliqués.
- **Valeur** totale de l'entrée (Quantité × Prix d'achat).
- **Observations** (ex: "achat initial", "réapprovisionnement", etc.).

*Vous pouvez utiliser la barre de recherche pour retrouver une entrée par article, fournisseur, date ou montant.*

### ⚠️ Annuler une entrée en stock (Supprimer)
Si vous avez fait une erreur de saisie, vous pouvez cliquer sur le bouton rouge **Supprimer**.
**Règles de sécurité :**
1. **Vérification du stock :** L'application refuse l'annulation si vous avez déjà vendu ou sorti cette marchandise. (Exemple : Si vous avez reçu 10 articles, mais que vous en avez déjà vendu 2, le stock actuel est de 8. L'application vous bloquera car vous ne pouvez pas annuler une entrée de 10).
2. **Mise à jour comptable :** Si l'annulation réussit, l'application retire la quantité du stock, et déduit le montant de la dette de votre fournisseur.

---

## 2. Enregistrer une nouvelle Entrée

Pour ajouter de la marchandise en stock, cliquez sur le bouton bleu **Nouvelle entrée en stock**.

![Formulaire d'entrée en stock](/images/docs/creation-entree.png)

1. **Sélectionner un article** : Choisissez l'article dans la liste déroulante. 
   *(Astuce : Vous pouvez aussi utiliser la "Recherche rapide" en tapant l'ID, la Référence ou le Code-barres).*
2. **Sélectionner un fournisseur** : Choisissez le fournisseur dans la liste. 
   *(Astuce : Utilisez la "Recherche rapide" avec l'ID, le Téléphone ou l'Email).*
3. **Quantité** *(Obligatoire)* : Saisissez la quantité reçue.
   - Si l'article est à l'unité, tapez un nombre entier (ex: 10).
   - Si l'article est en vrac (kilo, litre), tapez un nombre avec virgule (ex: 1.5).
4. **Prix total achat** *(Obligatoire)* : Saisissez le montant total que vous avez payé pour cette quantité (ex: 5000 MRU pour tout le lot).
5. **Prix achat unitaire** : Ce champ est en lecture seule. L'application le calcule automatiquement en divisant le *Prix total achat* par la *Quantité*. (Ex: 5000 / 10 = 500).
6. **Prix de vente** *(Obligatoire)* : C'est le nouveau prix auquel vous allez vendre cet article. Si vous le modifiez, le prix de vente de l'article sera mis à jour dans votre catalogue.
7. **Date** *(Obligatoire)* : Indiquez la date de réception.
8. Cliquez sur **Ajouter**.

*Résultat : Le stock de l'article augmente, le prix moyen d'achat est recalculé (selon la méthode CUMP/PEPS configurée), et la dette envers le fournisseur augmente.*
