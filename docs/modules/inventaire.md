# Inventaire des Articles

[⬅ Retour au sommaire](/documentation/user_guide)

Le menu **Articles > Inventaire des Articles** vous donne une vue d'ensemble complète et détaillée de l'état de votre stock. Il permet de justifier la quantité finale de chaque article en montrant tous les mouvements (entrées, sorties, pertes).

![Tableau d'inventaire](/images/docs/inventaire.png)

---

## 1. Comprendre le tableau

Le tableau se lit de gauche à droite pour chaque article. Il vous montre le parcours exact de l'article dans votre stock :

- **Id** et **Libellé** : L'identifiant et le nom de l'article.
- **Quantité minimale** : Le seuil d'alerte.
- **Stock initial** : La toute première quantité enregistrée lors de la création de l'article (ou de sa première entrée).
- **Entrées** : La somme totale des quantités reçues (achats, réapprovisionnements).
- **Sorties** : La somme totale des articles vendus.
- **Pertes** : La somme des articles perdus, cassés, périmés ou donnés.
- **Stock final** : C'est votre stock actuel. 
  - La couleur est **verte** si le stock est suffisant (supérieur ou égal à la quantité minimale).
  - La couleur est **rouge** si le stock est en alerte.
- **Unité de vente** : L'unité de l'article (unité, kilo, litre).
- **Prix d'achat** : Le coût d'achat unitaire actuel (calculé selon votre méthode de valorisation).
- **Valeur** : La valeur totale de cet article dans votre stock (Stock final × Prix d'achat).

---

## 2. Utilité

Cet écran est votre outil de contrôle de gestion principal. Il vous permet de :
1. **Vérifier la cohérence** : Le calcul `Stock initial + Entrées - Sorties - Pertes = Stock final` doit toujours être exact. S'il y a un décalage, c'est qu'il y a eu une erreur de saisie.
2. **Justifier les écarts** : Lors d'un inventaire physique, si vous comptez moins d'articles que le "Stock final", vous pouvez vérifier si une perte a bien été enregistrée dans le système.
3. **Suivre la valeur de votre stock** : La colonne "Valeur" vous donne la somme d'argent immobilisée dans vos articles.

*Vous pouvez utiliser la barre de recherche en haut pour filtrer par nom d'article, référence ou code-barres.*
