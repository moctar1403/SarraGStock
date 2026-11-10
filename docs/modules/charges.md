# Gestion des Charges (Dépenses)

[⬅ Retour au sommaire](/documentation/user_guide)

Le menu **Charges** vous permet de gérer vos dépenses courantes (loyer, électricité, eau, gaz, achats divers, etc.). Contrairement aux sorties de stock, les charges n'impactent pas l'inventaire de vos articles. Elles sont enregistrées de manière purement **analytique** pour vous aider à calculer votre **Profit Net** dans le tableau de bord.

![Liste des charges](/images/docs/liste-charges.png)

**Comprendre l'affichage :**
- Les charges sont listées par date (de la plus récente à la plus ancienne).
- Le montant est affiché en **rouge** pour indiquer une sortie d'argent.
- La colonne **Utilisateur** indique qui a enregistré la dépense (traçabilité).

*Vous pouvez utiliser la barre de recherche pour trouver une charge par son libellé, ses observations, son montant ou le nom de l'utilisateur.*

## 1. Créer une charge

Voici comment enregistrer une nouvelle dépense.

![Formulaire de création d'une charge](/images/docs/creation-charge.png)

1. Allez dans **Charges > Nouvelle Charge**.
2. Remplissez les champs suivants :

   - **Libellé** *(Obligatoire)* : Le nom de la dépense (ex: "Facture électricité Octobre", "Achat gaz", "Loyer"). Doit être une chaîne de caractères (max 255).
   - **Montant** *(Obligatoire)* : Le montant de la dépense. Doit être un nombre strictement supérieur à 0.
   - **Date** *(Obligatoire)* : La date réelle de la dépense (par défaut, la date du jour). Ce champ est crucial car c'est lui qui sera utilisé pour les filtres du tableau de bord.
   - **Observations** *(Optionnel)* : Un champ libre pour ajouter des précisions (ex: numéro de facture, fournisseur, motif...).

3. Cliquez sur **Enregistrer la charge** pour valider.

*(Note : Contrairement aux anciennes versions, la charge n'est plus liée à une méthode de paiement. Elle n'affecte donc pas le solde de votre caisse. Elle est uniquement destinée au calcul du Profit Net).*

## 2. Consulter et rechercher des charges

La liste des charges vous permet de retrouver rapidement une dépense.

- **Recherche** : Utilisez la barre de recherche pour filtrer par libellé, observation, montant ou nom d'utilisateur.
- **Pagination** : Les résultats sont paginés par 10 pour faciliter la navigation.
- **Statistiques** : En haut de la page, trois indicateurs vous donnent une vue d'ensemble :
  - **Total Charges** : Le nombre total de charges enregistrées.
  - **Charges aujourd'hui** : Le montant total des dépenses du jour.
  - **Charges du mois** : Le montant total des dépenses du mois en cours.

## 3. Supprimer une charge

Pour supprimer une charge, cliquez sur le bouton rouge **Supprimer** (icône poubelle) à côté de la charge concernée.

⚠️ **Attention : La suppression est définitive.**

- Une confirmation vous sera demandée via une fenêtre modale.
- **Aucune règle de blocage** n'est appliquée ici (contrairement aux articles). Vous pouvez supprimer une charge à tout moment.
- **Impact** : La suppression d'une charge **n'affecte pas** le solde de votre méthode de paiement (car les charges ne sont plus liées à une caisse). Le tableau de bord recalculera automatiquement le Profit Net sans cette charge.

## 4. Impact sur le Tableau de Bord

Les charges sont intégrées dans le calcul du **Profit Net** de votre tableau de bord (module `Homs3`).

- **Filtre par date** : Le tableau de bord utilise la **date de la charge** (`ch_date`) pour filtrer les dépenses sur la période sélectionnée.
- **Calcul** : Le Profit Net est calculé comme suit :
  `Profit Net = Total Ventes - Coût de revient - Pertes - Charges`
- **Affichage** : Les charges apparaissent dans le détail du calcul sous la ligne **"Charges"** (en rouge, avec un signe moins), et le **Total Charges** est également affiché en haut pour une visibilité immédiate.

*Astuce : Si vous constatez que vos charges sont trop élevées par rapport à vos ventes, pensez à vérifier vos dépenses fixes (loyer, abonnements) dans cette liste.*