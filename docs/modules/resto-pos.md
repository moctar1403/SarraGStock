# Module Caisse et Point of Sale (POS)

[⬅ Retour au sommaire](/documentation/user_guide)

Ce module est spécialement conçu pour la gestion d'un point de vente. Il permet de prendre des commandes sur un écran tactile, de gérer la caisse (ouverture, clôture) et de vendre aussi bien des plats préparés que des articles en stock.

---

## 1. Ouvrir une caisse

Avant de pouvoir vendre, vous devez ouvrir une session de caisse.

1. Allez dans **Caisse (Resto)**.
2. S'il n'y a pas de caisse ouverte, cliquez sur **Ouvrir une caisse**.
3. Saisissez le **Fond de caisse initial** (l'argent en espèces que vous mettez dans le tiroir-caisse pour faire la monnaie).
4. Cliquez sur **Ouvrir la caisse**.

*Une fois ouverte, vous êtes redirigé vers le menu pour commencer à vendre.*

---

## 2. Utiliser l'écran tactile (POS)

L'écran POS est divisé en deux parties : le catalogue à gauche et le ticket de caisse à droite.

### A. Basculer entre les modes de vente
En haut de l'écran, vous avez deux boutons :
- **🍽️ Restaurant** : Affiche uniquement les plats et boissons préparés (qui ne gèrent pas de stock).
- **📦 Articles de Stock** : Affiche les articles classiques avec leur quantité disponible.

*Vous pouvez mélanger les deux types d'articles dans un même ticket. La vente sera alors enregistrée comme **"Mixte"**.*

### B. Recherche rapide (Code-barres)
Dans la barre de recherche, vous pouvez scanner un code-barres, taper une référence ou un ID.
- La liste se filtrera automatiquement pour afficher l'article trouvé.
- Cliquez sur l'article pour l'ajouter au panier.
- Effacez le champ (ou cliquez sur la croix) pour revenir à la liste complète.

### C. Gérer le ticket
1. **Ajouter des articles** : Cliquez sur les boutons du catalogue.
2. **Modifier la quantité** : Utilisez le bouton "-" dans le panier pour retirer une unité.
3. **Appliquer une remise** : Cliquez sur "+ Accorder une remise" pour choisir un pourcentage ou un montant fixe.
4. **Valider** : Choisissez la méthode de paiement, puis cliquez sur **VALIDER LA VENTE**.

---

## 3. Clôturer la caisse (Rapport Z)

À la fin de la journée, vous devez fermer la caisse pour vérifier les comptes.

1. Depuis l'écran POS ou l'historique, cliquez sur **Clôturer**.
2. L'écran affiche le **Total théorique** (Fond de caisse + Ventes de la journée).
3. Comptez l'argent réellement présent dans votre tiroir-caisse et saisissez le montant dans **Montant réel compté**.
4. L'application calcule automatiquement l'**Écart** (Manquant ou Excédent).
5. Cliquez sur **Clôturer la caisse**.

*Une fois clôturée, la session est verrouillée et ne peut plus être modifiée.*