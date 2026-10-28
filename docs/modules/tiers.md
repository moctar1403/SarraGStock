# Gestion des Tiers (Clients & Fournisseurs)

[⬅ Retour au sommaire](/documentation/user_guide)

Le menu **Tiers** vous permet de gérer votre base de données de contacts, en séparant les Clients et les Fournisseurs.

---

## 1. Gestion des Clients

L'écran **Tiers > Clients** affiche la liste de tous vos clients, avec une barre de recherche et des boutons d'action.

![Liste des clients](/images/docs/liste-clients.png)

### A. Ajouter un Client
1. Sur l'écran de la liste des clients, cliquez sur le bouton bleu **Ajouter Client**.
2. Remplissez le formulaire :

![Formulaire d'ajout d'un client](/images/docs/ajout-client.png)

   - **Nom** *(Obligatoire)* : Le nom du client. **Doit être unique**.
   - **Civilité** *(Obligatoire)* : Sélectionnez M., Mme, etc. (minimum 2 caractères).
   - **Société** *(Obligatoire)* : Le nom de l'entreprise. **Doit être unique**.
   - **Téléphone** *(Obligatoire)* : Doit contenir **exactement 8 chiffres** et être unique.
   - **Adresse** *(Optionnel)*.
   - **Email** *(Optionnel)* : Doit être une adresse e-mail valide et unique.
   - **Observation** *(Optionnel)* : Notes libres.

3. Cliquez sur le bouton vert **Ajouter**.
*(Si une règle n'est pas respectée, un message d'erreur rouge apparaîtra sous le champ concerné).*

### B. Modifier un Client
1. Dans la liste, cliquez sur le bouton violet **Modifier** à côté du client souhaité.
2. Modifiez les informations nécessaires (les règles de validation restent identiques à la création).
3. Cliquez sur **Enregistrer**.

### C. Supprimer un Client
Pour supprimer un client, cliquez sur le bouton rouge **Supprimer** dans la liste.
⚠️ **Règles de sécurité :** L'application **refusera** de supprimer un client dans les cas suivants :
1. **Le client a des ventes en cours** : S'il est lié à une facture ou une vente.
2. **Le client a des paiements en cours** : S'il a un historique de paiement.

---

## 2. Gestion des Fournisseurs

L'écran **Tiers > Fournisseurs** est similaire à celui des clients, mais il inclut des raccourcis pour la gestion des paiements fournisseurs (voir capture ci-dessous).

![Liste des fournisseurs](/images/docs/liste-fournisseurs.png)

Depuis cet écran, vous avez 3 boutons en haut à droite :
- **Ajouter Fournisseur** : Pour créer un nouveau contact.
- **Liste Paiements Fournisseurs** : Pour voir l'historique des règlements.
- **Nouveau paiement Fournisseur** : Pour enregistrer un paiement direct.

### A. Ajouter un Fournisseur
1. Cliquez sur **Ajouter Fournisseur**.
2. Remplissez le formulaire (similaire à celui des clients) :
   - **Nom** *(Obligatoire, unique)*.
   - **Civilité** *(Obligatoire)*.
   - **Société** *(Obligatoire, unique)*.
   - **Téléphone** *(Obligatoire, exactement 8 chiffres, unique)*.
   - **Adresse** et **Email** *(Optionnels)*.
   - **Observations** *(Optionnel)*.
3. Cliquez sur **Ajouter**.

### B. Modifier un Fournisseur
1. Cliquez sur **Modifier** dans la liste.
2. Modifiez les informations nécessaires (les règles de validation restent les mêmes que pour l'ajout).
3. Cliquez sur **Modifier** pour sauvegarder.

### C. Supprimer un Fournisseur
Pour supprimer un fournisseur, cliquez sur le bouton rouge **Supprimer**.
⚠️ **Règles de sécurité :** L'application **refusera** de supprimer un fournisseur dans les cas suivants :
1. **Il a une entrée en stock** : Si vous avez déjà enregistré une réception de marchandise venant de ce fournisseur.
2. **Il a un historique de paiement** : Si vous avez déjà enregistré un règlement (même partiel) pour ce fournisseur.
