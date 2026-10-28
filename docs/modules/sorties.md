# Sorties des Articles (Pertes, Casses, etc.)

[⬅ Retour au sommaire](/documentation/user_guide)

Pour gérer les sorties de stock (pertes, casses, péremptions), allez dans **Articles > Sorties des Articles**. 

Cet écran vous permet de retirer des articles du stock **sans qu'ils soient vendus**. Par exemple : un produit périmé, de la casse lors du transport, un vol, ou un don. 

*(Note : Il ne faut jamais utiliser l'écran "Vente" pour enregistrer une perte, car cela fausserait votre chiffre d'affaires et créerait une fausse dette client).*

---

## 1. Consulter l'historique des sorties

![Liste des sorties de stock](/images/docs/liste-sorties.png)

L'écran affiche la liste de tous les mouvements de sortie. Pour vous aider à vous y retrouver, un **badge de couleur** indique le motif de la sortie :

- 🟢 **Vente** (Vert) : Sortie générée automatiquement par une facture de vente.
- 🔴 **Perte** (Rouge) : Sortie manuelle (casse, péremption, vol).
- 🔵 **Détail** (Bleu) : Sortie générée par une opération de conditionnement (casser une caisse).

**Actions disponibles :**
Vous pouvez annuler une **Perte** en cliquant sur le bouton rouge **Supprimer**. 
*(Attention : Vous ne pouvez pas supprimer une ligne "Vente" ou "Détail" depuis cet écran. Pour annuler une vente, vous devez supprimer la facture correspondante dans le menu "Ventes").*

---

## 2. Enregistrer une nouvelle Sortie

Pour déclarer une perte ou une casse, cliquez sur le bouton bleu **Nouvelle sortie de stock**.

![Formulaire de sortie de stock](/images/docs/creation-sortie.png)

1. **Sélectionner un article** *(Obligatoire)* : Choisissez l'article dans la liste déroulante. 
   *(Astuce : Vous pouvez utiliser la "Recherche rapide" en tapant l'ID, la Référence ou le Code-barres).*
2. **Motif de sortie** *(Obligatoire)* : Sélectionnez le motif. Actuellement, le motif principal est **"Perte"**.
3. **Quantité disponible** : Ce champ se remplit automatiquement pour vous indiquer le stock actuel de l'article.
4. **Quantité à sortir** *(Obligatoire)* : Saisissez la quantité perdue. 
   - Le format (entier ou décimal) dépend de l'unité de l'article.
   - La quantité ne peut pas être supérieure à la "Quantité disponible" (sinon une erreur rouge s'affiche).
5. **Date** *(Obligatoire)* : Indiquez la date à laquelle la perte a été constatée.
6. Cliquez sur **Ajouter**.

*Résultat : La quantité est immédiatement déduite de votre stock. L'opération est tracée pour votre comptabilité afin de justifier l'écart d'inventaire.*
