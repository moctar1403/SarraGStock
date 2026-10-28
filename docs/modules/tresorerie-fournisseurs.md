# Trésorerie : Paiements Fournisseurs

[⬅ Retour au sommaire](/documentation/user_guide)

Ce module vous permet d'enregistrer les décaissements (paiements) que vous effectuez pour régler vos dettes envers vos fournisseurs. Il est utilisé pour solder les achats de marchandises.

Pour y accéder, allez dans **Fournisseurs > Liste Paiements Fournisseurs**.

---

## 1. Consulter l'historique des paiements

![Liste des paiements fournisseurs](/images/docs/liste-paiements-fournisseurs.png)

L'écran affiche la liste de tous les règlements effectués :
- Le **Fournisseur**.
- Le **Montant** payé.
- Le **Type de paiement** (Espèces, Virement, etc.).
- La **Date de paiement**.

*Vous pouvez utiliser la barre de recherche pour retrouver un paiement par nom de fournisseur ou par date.*

### ⚠️ Annuler un paiement (Supprimer)
Si vous avez enregistré un paiement par erreur, cliquez sur le bouton rouge **Supprimer**.
**Conséquences de l'annulation :**
- Le montant payé (y compris les frais) est remis dans votre caisse.
- La dette du fournisseur ré-augmente (sa situation est recalculée).

---

## 2. Enregistrer un nouveau Paiement Fournisseur

Pour payer un fournisseur, cliquez sur le bouton bleu **Nouveau paiement Fournisseur**.

![Formulaire de paiement fournisseur](/images/docs/creation-paiement-fournisseur.png)

1. **Sélectionner un fournisseur** *(Obligatoire)* : 
   - Seuls les fournisseurs envers qui vous avez une **dette (situation > 0)** apparaissent dans cette liste.
   - *Astuce : Utilisez la "Recherche rapide" avec l'ID, le Téléphone ou l'Email.*
2. **Montant** *(Obligatoire)* : 
   - L'application affiche la **Situation du fournisseur** (le total que vous lui devez).
   - Saisissez le montant de la dette que vous payez. **Attention :** vous ne pouvez pas payer plus que la dette.
3. **Frais** *(Optionnel)* : Saisissez les frais liés au paiement (frais de transfert, frais bancaires). Par défaut, ce champ est à 0. 
   *(Note : Le total qui sortira de votre caisse sera le Montant + les Frais).*
4. **Type de paiement** *(Obligatoire)* : Choisissez la méthode utilisée (Espèces, Bankily, etc.).
5. **Date** *(Obligatoire)* : La date d'envoi de l'argent.
6. Cliquez sur **Ajouter**.

*Résultat : L'argent (Montant + Frais) est déduit de votre caisse, et la dette du fournisseur est diminuée du montant payé.*
