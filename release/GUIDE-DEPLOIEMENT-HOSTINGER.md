# Guide de déploiement — Top-Famille Pro sur Hostinger

> Destiné à un utilisateur non développeur. Suivez les étapes dans l'ordre. À chaque étape
> marquée **⚠️**, arrêtez-vous et vérifiez avant de continuer plutôt que d'avancer en cas de doute.
>
> Ce que vous installez : le thème `topfamillepro-theme.zip` (l'apparence et le fonctionnement du
> site) et le plugin `topfamillepro-content-installer.zip` (un outil temporaire qui crée les 53
> pages réelles du site en un clic, sans terminal). Les deux fichiers sont dans ce même dossier de
> livraison.

---

> **Site déjà en ligne avec un autre thème actif (ex. `V1top-famille-pro`) ?** Ce guide décrit une
> installation sur un WordPress neuf. Si le site est déjà publié avec un thème différent, utilisez
> à la place `topfamillepro-theme-correctif.zip` et `topfamillepro-content-installer-correctif.zip`
> (mêmes étapes ci-dessous, fichiers renommés), et suivez la procédure pas à pas de
> `docs/AUDIT-PRODUCTION.md` §11 (staging d'abord, ancien thème conservé le temps de la validation,
> jamais de modification directe de la production) et §12 (retour arrière). Le plugin correctif
> ajoute une section « Contenu existant à examiner » qui signale, sans jamais rien supprimer, tout
> contenu publié qui n'appartient pas aux 53 pages attendues — typiquement les pages d'un thème
> précédent.

## Partie A — Installation depuis l'administration WordPress (méthode recommandée)

### 1. Créer une sauvegarde

Avant toute chose : dans hPanel Hostinger, section **Sauvegardes**, créez une sauvegarde complète
(fichiers + base de données) si le site existe déjà. Si vous partez d'un hébergement neuf, cette
étape ne s'applique pas encore — mais revenez-y après l'étape 10.

### 2. Installer WordPress avec hPanel

Dans hPanel : **Sites web → Créer un site → WordPress**, ou **Auto-installateur → WordPress** selon
la version de hPanel. Renseignez le domaine `top-famille-pro.fr`, un identifiant et un mot de passe
administrateur solides (notez-les dans un gestionnaire de mots de passe). Terminez l'installation.

### 3. Activer HTTPS

Dans hPanel : **Sécurité → SSL**, activez le certificat SSL gratuit (Let's Encrypt) pour
`top-famille-pro.fr`. Attendez sa validation (quelques minutes en général), puis dans
**WordPress → Réglages → Général**, vérifiez que l'adresse du site (URL WordPress et URL du site)
commence bien par `https://`.

### 4. Installer GeneratePress depuis WordPress

Le thème livré est un **thème enfant** : il a besoin du thème parent **GeneratePress** installé et
présent (pas nécessairement activé) pour fonctionner. Dans l'administration WordPress :
**Apparence → Thèmes → Ajouter un thème**, recherchez « GeneratePress », cliquez sur **Installer**.
N'activez pas encore GeneratePress lui-même — l'étape 6 activera directement le thème enfant.

### 5. Téléverser `topfamillepro-theme.zip`

**Apparence → Thèmes → Ajouter un thème → Téléverser un thème** (bouton en haut de la page,
à côté de « Ajouter un thème »). Sélectionnez le fichier `topfamillepro-theme.zip` de ce dossier de
livraison, cliquez sur **Installer maintenant**.

**⚠️ Ne téléversez jamais un fichier ZIP de thème via le gestionnaire de fichiers à la racine de
`public_html`** — un thème s'installe uniquement via ce champ de téléversement WordPress (ou via la
procédure alternative de la Partie B), jamais en l'extrayant n'importe où sur le serveur.

### 6. Activer le thème enfant

Une fois l'installation terminée, cliquez sur **Activer**. Si un message d'erreur mentionne le
thème parent, revenez à l'étape 4 : GeneratePress doit être installé (même sans être activé)
avant que le thème enfant puisse s'activer.

### 7. Installer ACF gratuit

**Extensions → Ajouter une extension**, recherchez « Advanced Custom Fields », installez et activez
la version **gratuite** (celle de WP Engine/Delicious Brains, pas une version « Pro » payante — le
thème n'utilise aucune fonctionnalité réservée à ACF Pro). Le thème fonctionne aussi sans ACF, mais
son activation permet d'éditer les champs des prestations et des zones directement depuis
l'administration si besoin plus tard.

### 8. Téléverser `topfamillepro-content-installer.zip`

**Extensions → Ajouter une extension → Téléverser une extension**. Sélectionnez le fichier
`topfamillepro-content-installer.zip`, cliquez sur **Installer maintenant**, puis **Activer**.

### 9. Lancer le mode simulation

Menu **Outils → Installation Top-Famille Pro**. La page affiche immédiatement un tableau
« Contrôle préalable » : c'est la simulation — il indique, sans rien modifier, tout ce qui sera créé
(colonne « Manquant »). Sur un site neuf, vous devez y voir les 52 contenus attendus (18 pages moins
l'accueil, 6 prestations, 26 zones, 3 articles) marqués comme manquants.

### 10. Lancer l'installation

Cochez la case **« J'ai sauvegardé le site avant de continuer »**, puis cliquez sur
**Installer ou mettre à jour le contenu**. L'opération dure quelques secondes à quelques minutes.
Un rapport détaillé s'affiche : une ligne par étape, avec le nombre de contenus créés par type
(avant/après). Vérifiez qu'aucune étape n'est marquée en erreur (⛔). Si une erreur apparaît,
ne continuez pas la suite du guide : notez le message exact et faites-le remonter avant de
poursuivre.

**Revenez maintenant à l'étape 1** si vous ne l'avez pas encore fait : sauvegardez le site
maintenant qu'il contient son contenu réel.

### 11. Vérifier les 53 pages

Retournez sur **Outils → Installation Top-Famille Pro** : le tableau de contrôle doit maintenant
afficher 52/52 partout (colonne « Manquant » vide). Parcourez rapidement **Pages**,
**Prestations**, **Zones**, et **Articles** dans le menu d'administration pour confirmer visuellement
leur présence. Le détail exact de chaque page (titre, URL, gabarit) est dans
`PAGES-A-CREER.md` / `pages-a-creer.csv`, fournis dans ce même dossier — utilisez-les comme
référence de contrôle, ou comme solution de secours si l'installateur ne peut pas être utilisé.

### 12. Enregistrer les permaliens

**Réglages → Permaliens**. Choisissez la structure **« Nom de l'article »** (ou toute structure
autre que « Simple ») si ce n'est pas déjà le cas, puis cliquez sur **Enregistrer les
modifications** — même sans rien changer, cet enregistrement force WordPress à reconstruire ses
règles de réécriture d'URL, nécessaire pour que les adresses des prestations et des zones
fonctionnent. Testez ensuite une URL de prestation (ex. `/prestations/bureaux/`) : elle doit
afficher la page, pas une erreur 404.

### 13. Créer ou contrôler les menus

**Rien à faire ici.** La navigation (menu principal, sous-menus Prestations/Zones, menu mobile) est
intégrée directement dans le thème — ce n'est pas un menu WordPress (Apparence → Menus) à
construire. Vérifiez simplement, en visitant le site, que le menu s'affiche correctement en haut de
page et que le menu mobile (icône ☰) s'ouvre sur petit écran.

### 14. Définir l'accueil

**Rien à faire ici non plus.** Le thème affiche automatiquement la page d'accueil réelle sur `/`
via son gabarit dédié (`front-page.php`), quel que soit le réglage **Réglages → Lecture → Vos
premiers pas → La page d'accueil affiche**. Vous pouvez laisser ce réglage sur sa valeur par
défaut (« Vos derniers articles ») sans que cela affecte l'accueil du site.

### 15. Renseigner les vraies informations de réassurance

Cherchez dans l'administration le réglage **Réassurance & avis** (ajouté par le thème, en général
sous Réglages). Renseignez-y, dès qu'elles sont disponibles : l'URL de la fiche Google Business, la
note réelle, le nombre d'avis réels, et le texte exact des témoignages autorisés. Tant que ces
informations ne sont pas fournies, le site affiche honnêtement un état neutre (« avis à venir ») —
c'est le comportement normal, pas un défaut à corriger autrement qu'en fournissant les vraies
valeurs. Voir aussi `INFORMATIONS-MANQUANTES.md`.

### 16. Configurer la boîte de réception des devis

Le formulaire de devis (`/demande-de-devis/`) envoie réellement les demandes par e-mail à
l'adresse définie dans le thème (`includes/site-options.php`, champ `email`). Confirmez que cette
adresse est bien surveillée, ou faites modifier le thème si une autre adresse doit être utilisée.

### 17. Configurer SMTP

Sur la plupart des hébergements Hostinger, l'envoi d'e-mail standard PHP (`mail()`) fonctionne sans
configuration supplémentaire pour un domaine hébergé chez eux. **Si les e-mails de devis
n'arrivent pas** (à vérifier à l'étape suivante), installez un plugin SMTP (ex. « WP Mail SMTP »)
et configurez-le avec les identifiants d'un service d'envoi (ex. celui déjà utilisé pour
`top-famille.fr`, ou un compte SMTP Hostinger dédié) — aucune configuration SMTP n'est codée en dur
dans le thème, `wp_mail()` utilise le transport disponible sur l'hébergement.

### 18. Envoyer un vrai devis de test

Depuis le site en ligne (pas en aperçu), remplissez et envoyez le formulaire de
`/demande-de-devis/` avec vos propres coordonnées de test. Vérifiez : (a) que la page de
confirmation s'affiche, (b) qu'un e-mail arrive bien dans la boîte configurée à l'étape 16,
en quelques minutes. **C'est le seul test qui ne peut pas être fait avant la mise en ligne réelle**
(l'environnement de développement n'a pas de transport mail).

### 19. Configurer LiteSpeed Cache

**Extensions → Ajouter une extension**, installez et activez **LiteSpeed Cache** (généralement déjà
disponible ou pré-suggéré sur l'hébergement Hostinger). Activez au minimum : la mise en cache des
pages **et la compression (Brotli ou gzip)**. C'est une étape obligatoire, pas optionnelle.

**Vérifiez la compression avant de considérer l'étape faite.** C'est le point qui décide de la note
de performance, et il est mesurable en une commande :

```bash
curl -s -o /dev/null -D - -H 'Accept-Encoding: br, gzip' \
  https://top-famille-pro.fr/wp-content/themes/topfamillepro/assets/dist/css/main.css | grep -i 'content-encoding'
```

La réponse doit contenir `content-encoding: br` (ou `gzip`). Si cette ligne est absente, la feuille
de style est servie en 59 Ko au lieu de 10 : sur un lien mobile, cela coûte à soi seul près d'une
seconde de premier rendu, et fait passer la note de performance de 92-100 à 83-96. Les deux séries
de mesures sont dans `docs/RAPPORT-FIDELITE-FINALE.md` §6.

N'activez **pas** le chargement asynchrone ou différé du CSS principal proposé par LiteSpeed : la
feuille de style du thème est volontairement synchrone, sinon la page s'affiche un instant sans
style.

### 20. Vérifier le sitemap et robots.txt

Visitez `https://top-famille-pro.fr/wp-sitemap.xml` : il doit lister les pages, prestations, zones
et articles réels, **sans** les 8 communes secondaires non validées (elles restent
`noindex,follow`, exclues du sitemap par le thème). Visitez `https://top-famille-pro.fr/robots.txt`
: il doit contenir une ligne `Sitemap:` pointant vers l'URL ci-dessus.

### 21. Tester la version mobile

Sur un vrai téléphone (ou l'outil d'inspection mobile de votre navigateur), parcourez l'accueil, une
page prestation, une page zone, et le formulaire de devis complet (les deux étapes). Vérifiez
l'absence de débordement horizontal et que tous les boutons sont atteignables au doigt.

### 22. Désactiver et supprimer le plugin d'installation

**Extensions**, repérez **Top-Famille Pro — Installation du contenu**, cliquez sur **Désactiver**
puis **Supprimer**. Son rôle est terminé : il ne doit **pas** rester actif ni installé en
production (aucune raison de garder un outil de création de contenu accessible une fois le contenu
en place).

### 23. Faire une nouvelle sauvegarde

Une fois les étapes 1 à 22 terminées et vérifiées, faites une nouvelle sauvegarde complète
(fichiers + base) — c'est votre point de restauration « site fonctionnel, avant ouverture de
l'indexation ».

### 24. Effectuer la recette avant ouverture de l'indexation

Avant d'annoncer publiquement le site ou de le laisser indexer par les moteurs de recherche,
relisez `docs/RAPPORT-FINAL.md` (dans le dépôt du thème) : verdict global, ce qui reste
véritablement manquant (`INFORMATIONS-MANQUANTES.md`), et la checklist complète des points déjà
vérifiés. Ne considérez le site prêt pour l'indexation publique qu'une fois ce rapport relu.

---

## Partie B — Procédure alternative par le gestionnaire de fichiers Hostinger

À utiliser uniquement si le téléversement depuis l'administration WordPress (étape 5) échoue
(ex. limite de taille d'upload trop basse côté hébergement).

1. Dans hPanel : **Fichiers → Gestionnaire de fichiers**, naviguez jusqu'à :
   ```
   public_html/wp-content/themes/
   ```
   **Emplacement exact attendu après extraction : `public_html/wp-content/themes/topfamillepro/`**

2. **⚠️ Précautions avant extraction :**
   - Téléversez `topfamillepro-theme.zip` **dans** `wp-content/themes/`, jamais à la racine de
     `public_html`. Extraire un thème à la racine du site ne l'installera pas et risque de
     mélanger ses fichiers avec ceux de WordPress lui-même.
   - Si un dossier `topfamillepro/` existe déjà à cet emplacement (installation précédente),
     renommez-le (ex. `topfamillepro-ancien/`) plutôt que d'écraser directement — vous pourrez
     supprimer l'ancien dossier une fois la nouvelle version confirmée fonctionnelle.

3. Téléversez `topfamillepro-theme.zip` dans `wp-content/themes/`, puis utilisez la fonction
   **Extraire** du gestionnaire de fichiers sur ce ZIP.

4. **Vérifiez immédiatement l'absence d'un double dossier** `topfamillepro/topfamillepro/` :
   ouvrez `wp-content/themes/topfamillepro/` et confirmez que vous voyez directement les fichiers
   du thème (`style.css`, `functions.php`, `includes/`, …) et non un second dossier
   `topfamillepro/` imbriqué. Si un double dossier existe, déplacez son contenu un niveau au-dessus
   puis supprimez le dossier vide en trop.

5. Supprimez le fichier `topfamillepro-theme.zip` du serveur une fois l'extraction confirmée (pas
   besoin de le garder sur l'hébergement).

6. Retournez dans l'administration WordPress : **Apparence → Thèmes**. Le thème
   **Top-Famille Pro** doit apparaître dans la liste (inactif). Activez-le comme à l'étape 6 de la
   Partie A.

7. **Si l'activation échoue** (page blanche, message d'erreur) :
   - Ne paniquez pas : le thème précédemment actif reste actif tant que vous n'en activez pas un
     autre avec succès — WordPress ne désactive le thème courant qu'au moment où l'activation du
     nouveau réussit.
   - Vérifiez que GeneratePress est bien installé (étape 4, Partie A) : c'est la cause la plus
     fréquente d'échec d'activation d'un thème enfant.
   - Pour revenir en arrière proprement : dans le gestionnaire de fichiers, supprimez le dossier
     `wp-content/themes/topfamillepro/` fautif, puis recommencez le téléversement.

Le plugin `topfamillepro-content-installer.zip` suit exactement la même procédure, dans
`public_html/wp-content/plugins/` au lieu de `themes/`.

---

## Décision juridique à réexaminer si la clientèle change

**La rubrique « Médiation de la consommation » n'est pas publiée sur les mentions légales.**

Le dispositif de médiation de la consommation (code de la consommation, articles L612-1 et
suivants) impose à un professionnel de garantir au **consommateur** l'accès gratuit à un médiateur,
et d'en publier les coordonnées. Il ne couvre pas les litiges entre professionnels.

Top-Famille Pro vend des prestations de nettoyage à des clients professionnels — entreprises,
commerces, cabinets, syndics, gestionnaires de meublés. Dans ce périmètre, la rubrique n'aurait
rien à annoncer ; y afficher un médiateur non désigné serait une information fausse, et un
placeholder visible n'a pas sa place sur des mentions légales publiées.

**À réexaminer sans délai si l'un de ces cas se présente :**

- vente d'une prestation à un particulier, même ponctuelle (déménagement, remise en état d'un
  logement, entretien d'une résidence secondaire) ;
- contrat avec un client dont l'activité relève du non-professionnel au sens du code de la
  consommation (certaines associations, copropriétaires agissant à titre privé) ;
- ouverture d'une offre destinée aux particuliers, distincte de l'offre Top-Famille B2C existante.

Dans ces cas : adhérer à un médiateur de la consommation agréé, puis publier son nom, son adresse
postale et son site sur les mentions légales et dans les conditions de vente.
