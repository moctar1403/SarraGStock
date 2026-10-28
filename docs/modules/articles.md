# Gestion des Articles (Catalogue) et Conditionnement

[⬅ Retour au sommaire](/documentation/user_guide)

Le menu **Articles** vous permet de gérer votre catalogue de produits. Il affiche la liste de tous vos articles avec leurs prix, leur stock actuel et leurs seuils d'alerte.

![Liste des articles](/images/docs/liste-articles.png)

**Comprendre les couleurs de la colonne "Quantité" :**
- **En vert** : Le stock est suffisant (la quantité est supérieure ou égale à la quantité minimale).
- **En rouge** : Le stock est faible ou en alerte (la quantité est inférieure à la quantité minimale). Il est temps de réapprovisionner !

*Vous pouvez utiliser la barre de recherche pour trouver un article par son nom, sa référence, sa description ou son code-barres.*

## 1. Créer un article normal
Voici comment ajouter un produit standard à votre stock.

![Formulaire de création d'un article](/images/docs/creation-article.png)

1. Allez dans **Articles > Liste des articles**.
2. Cliquez sur le bouton bleu **Nouveau Article** (en haut à droite).
3. Remplissez les champs en respectant les règles suivantes :

   - **Libellé Article** *(Obligatoire)* : Le nom de votre produit (ex: "Ciment 50kg"). **Il doit être unique** (vous ne pouvez pas créer deux articles avec le même nom).
   - **Référence** *(Optionnel)* : Le code interne de l'article (ex: ART-001). Si renseigné, il doit être unique.
   - **Description** *(Obligatoire)* : Une courte description du produit.
   - **Code barre** *(Optionnel)* : Doit être un nombre entier et unique s'il est renseigné.
   - **Unité de vente** *(Obligatoire)* : Sélectionnez l'unité (ex: Unité, Kilogramme, Litre).
   - **Quantité** *(Obligatoire)* : La quantité initiale. **Attention, le format dépend de l'unité choisie :**
     - Si l'unité est **"Unité"** (objets indivisibles), la quantité doit être un **nombre entier** (ex: 1, 5, 10). Les virgules ne sont pas acceptées.
     - Si l'unité est **"Kilogramme"**, **"Litre"** ou autre mesure, la quantité peut être un **nombre décimal** (ex: 1.5, 2.75).
     - Dans les deux cas, la quantité doit être strictement supérieure à 0.
   - **Quantité minimale** *(Obligatoire)* : Le seuil d'alerte. Doit être un nombre entier supérieur à 0.
   - **Prix total achat** *(Obligatoire)* : Le coût total d'achat. Doit être supérieur à 0.
   - **Prix achat** *(Obligatoire)* : Le coût d'achat unitaire. Doit être supérieur à 0.
   - **Prix de vente** *(Obligatoire)* : Le prix auquel vous vendez l'article. Doit être supérieur à 0.

4. Cliquez sur **Ajouter** pour enregistrer.

*(Note : Si un champ est mal rempli, un message d'erreur rouge apparaîtra sous celui-ci pour vous indiquer la correction à apporter).*

## 2. Modifier un article
Pour modifier un article existant, cliquez sur le bouton violet **Modifier** dans la liste des articles. 
**Attention, les règles de modification sont les suivantes :**

- **Référence** et **Code barre** restent **Optionnels** (mais doivent être uniques s'ils sont renseignés).
- **Description** n'a plus besoin d'être unique (vous pouvez avoir plusieurs articles avec la même description).
- **Quantité** : Le format (entier ou décimal) dépend de l'unité choisie. La quantité **doit être strictement supérieure à 0**. *(Note : Pour ajuster un stock (casse, perte), il faut passer par le module de Sorties de stock ou d'Entrées, et non modifier la fiche article).*
- Les autres règles (Libellé unique, Prix > 0, etc.) restent identiques à la création.

## 3. Supprimer un article
Pour supprimer un article, cliquez sur le bouton rouge **Supprimer** à côté de l'article concerné dans la liste.
⚠️ **Attention : La suppression est définitive et soumise à des règles strictes.**

**Règles de sécurité (L'application peut bloquer la suppression) :**
Pour garantir l'intégrité de vos données, l'application **refusera** de supprimer un article dans les cas suivants :
1. **L'article a un mouvement de stock** : S'il existe déjà une *Entrée* ou une *Sortie* de stock enregistrée pour cet article, il ne peut pas être supprimé (pour ne pas fausser l'historique de l'inventaire).
2. **L'article est un "Article principal"** : S'il est lié à un article de détail (ex: vous essayez de supprimer la "Caisse" alors que la "Bouteille" est liée), la suppression est bloquée. Il faut d'abord supprimer la liaison dans le module *Détailler un article*.
3. **L'article est un "Article de détail"** : S'il est le détail d'un autre article, il ne peut pas être supprimé.

*Si vous tentez de supprimer un article bloqué, un message d'alerte rouge apparaîtra en haut de l'écran vous expliquant la raison exacte du blocage.*

## 4. Détailler un Article (Conditionnement)

Certains articles sont achetés et stockés en gros (ex: une caisse de 12 bouteilles d'eau), mais peuvent être vendus à l'unité. La fonction **Détailler un article** permet de gérer ce système.

### A. Créer un article de détail
Avant de pouvoir "casser" une caisse, il faut créer l'article qui représentera l'unité de base.
1. Allez dans **Articles > Nouvel Article**.
2. Remplissez les champs obligatoires (Libellé, Description, Prix de vente).
3. ⚠️ **Point crucial :** Dans le champ **Unité de vente**, sélectionnez impérativement **"Article de détail"**.
4. L'application ne vous obligera pas à remplir les champs de quantité et de prix d'achat. Ils seront calculés et mis à jour automatiquement.
5. Cliquez sur **Ajouter** pour enregistrer l'article.

### B. Lier l'article principal à son détail
Maintenant, il faut dire à l'application que "1 Caisse" contient "12 Bouteilles".
1. Allez dans **Articles > Détailler un article > Liste des articles détaillables**.
2. Cliquez sur **Ajouter un article de détail**.
3. **Choisissez l'article principal** et l'**article de détail**.
4. Indiquez la **Quantité de l'article détail par unité d'article principal** (ex: `12`).
5. Cliquez sur **Ajouter** pour valider la liaison.

### C. Effectuer une opération de détail (Casser une caisse)
Lorsque vous voulez vendre les bouteilles à l'unité, vous devez d'abord "détailler" la caisse dans le système.
1. Allez dans **Articles > Détailler un article > Liste des opérations de détail**.
2. Cliquez sur **Effectuer une opération de détail**.
3. **Sélectionnez l'Article principal**.
4. Indiquez la **Quantité sortie de l'Article principal** (ex: `2` caisses).
5. L'application calcule automatiquement la **Quantité Totale entrée** (ex: 24 bouteilles).
6. Choisissez la **Date** de l'opération et validez.
