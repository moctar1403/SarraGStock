# Prérequis pour l'installation sur votre PC

Pour que l'application **SarraGStock** fonctionne correctement sur votre ordinateur, veuillez vérifier les points suivants avant de la lancer. 

---

## 1. Système d'exploitation

L'application est compatible avec :
- **Windows 10** (64 bits)
- **Windows 11** (64 bits)

---

## 2. Installation des bibliothèques Microsoft (Indispensable)

Si l'application affiche une **page blanche** ou une **erreur 500** au démarrage, c'est probablement parce que les bibliothèques de base de Microsoft ne sont pas installées sur votre PC.

**Que faire ?**
1. Téléchargez le fichier officiel de Microsoft : **VC_redist.x64** (Visual C++ Redistributable).
2. Double-cliquez sur le fichier téléchargé pour l'installer.
3. **Redémarrez votre ordinateur** une fois l'installation terminée.

---

## 3. Autorisation du Pare-feu Windows (Indispensable)

Lors du premier lancement, Windows peut bloquer l'application car elle utilise un serveur interne pour fonctionner. 
Si vous voyez un message comme *"Un serveur local interne a été bloqué par votre pare-feu"*, voici comment le débloquer :

1. Ouvrez le **Panneau de configuration** de Windows.
2. Cliquez sur **Système et sécurité**, puis **Pare-feu Windows Defender**.
3. Dans le menu de gauche, cliquez sur **Autoriser une application via le Pare-feu Windows Defender**.
4. Cliquez sur le bouton **Modifier les paramètres** (en haut à droite).
5. Cliquez sur **Autoriser une autre application...**.
6. Cliquez sur **Parcourir** et sélectionnez ces **deux fichiers** :
   - `C:\SarraGstock\phpdesktop\phpdesktop.exe`
   - `C:\SarraGstock\phpdesktop\php\php.exe`
7. Cochez les cases **Privé** et **Public** pour les deux fichiers.
8. Cliquez sur **OK** pour valider, puis redémarrez l'application.

*(Note : Si vous utilisez un antivirus tiers comme Avast, Kaspersky ou ESET, vous devrez également ajouter le dossier `C:\SarraGstock` à la liste des exceptions).*