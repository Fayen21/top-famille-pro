# Validation humaine — passe G25

> Fiche de décision pour la relecture des captures. **Rien n'est validé d'office** : chaque page
> porte le statut « À VALIDER » tant qu'Emmanuel ou Audrey ne l'a pas tranché. La revue tient en
> quelques minutes avec la sélection prioritaire.
>
> **Comment relire :** ouvrir `docs/captures/VALIDATION-G25.html` dans un navigateur (fonctionne
> hors ligne). Chaque image montre, de gauche à droite : la maquette Claude Design, le rendu
> WordPress, et leur différence — les zones sombres du troisième panneau sont les écarts.
> La sélection prioritaire (24 comparaisons) est en tête ; les 88 autres triptyques sont dépliables
> en dessous, et restent disponibles dans `docs/captures/comparaison/`.

## État technique au moment de la relecture

Zéro `DEFAUT_THEME` · 7 différences autorisées documentées (5 éditoriales, 2 légales) · 50/50
routes non légales dans 95–105 % aux six largeurs · CLS ≤ 0,0016 partout · 14/14 Lighthouse aux
cibles · 919 assertions vertes. La fidélité **n'est pas** déclarée validée pour autant : c'est
l'objet de cette relecture.

## Pages prioritaires

### 1. Accueil (`accueil-375/1440.jpg`)
- **Correspond** : les 13 bandes, dans l'ordre de la maquette ; hero, pastille tarifaire (libellé
  réaligné G25 : « régulier ou ponctuel »), carte segmentée des prestations, couverture régionale,
  portrait, conseils.
- **Différences intentionnelles** : la bande de réassurance n'ouvre pas sur la note Google
  (CLAUDE.md §9 — une preuve dans le hero + une section avis suffisent) ; bandeau « tarif unique
  en région » (libellé de la maquette, §5.3).
- **À regarder** : la pastille tarifaire du hero (deux lignes, comme la maquette) et la carte des
  huit départements à droite de la colonne de liens.
- **Statut proposé : À VALIDER**

### 2. Page pilier (`nettoyage-professionnel-375/1440.jpg` + zoom `pilier-bande-vignettes-375/1440.jpg`)
- **Correspond** : 19 bandes, 10 images sur 10 — dont les **six vignettes de prestations ajoutées
  en G25** (bande marine « Nos six prestations », 56×56, rayon 10, mêmes photos que la maquette,
  ordre identique).
- **Différences intentionnelles** : alt honnêtes (« photo d'illustration ») au lieu des alt de la
  maquette qui présentent des photos de stock comme des personnes réelles (§5.6) ; pastille de
  note posée seule au-dessus du H1 (comme la maquette).
- **À regarder** : le zoom de la bande des vignettes — c'est LE changement de cette passe.
- **Statut proposé : À VALIDER**

### 3. Prestation — bureaux (`service-bureaux-375/1440.jpg`)
- **Correspond** : hero avec image exacte, réponse directe en colonne de lecture 820 px, listes,
  bande Exemple + témoignage aux ordonnées décalées comme la maquette.
- **Différences intentionnelles** : mention visible « exemple de présentation » sur le témoignage
  provisoire (§5.5).
- **À regarder** : la bande « Exemple · 12 h/mois » (carte blanche, montant en bleu).
- **Statut proposé : À VALIDER**

### 4. Ville — Dijon (`ville-dijon-375/1440.jpg`)
- **Correspond** : bande tarifaire trois colonnes, tuiles marine des prestations, rangées de
  communes, liens de ville sur une ligne.
- **Différences intentionnelles** : CTA contextuel « Demander un devis à Dijon » (§8).
- **Statut proposé : À VALIDER**

### 5. Tarifs (`nos-tarifs-375/1440.jpg`)
- **Correspond** : bandeau deux cartes, grille des facteurs, tableau de budgets, témoignage nu et
  centré comme la maquette.
- **Différences intentionnelles** : « 5,0/5 **sur Google** » (jamais la note sans sa plateforme,
  §5.5) ; attribution du témoignage en #4A6273/14 px (la valeur déclarée par la maquette — et la
  seule accessible sur fond turquoise).
- **Statut proposé : À VALIDER**

### 6–7. Formulaire, étapes 1 et 2 (`formulaire-etape-1/2-375/1440.jpg`)
- **Correspond** : les deux étapes pilotées à l'identique des deux côtés — mêmes champs, même
  colonne d'information, même carte de réassurance.
- **Différences intentionnelles** : mentions de confidentialité et protections du formulaire
  (validation, honeypot) sans effet visuel.
- **Statut proposé : À VALIDER**

### 8. Article — fréquence bureaux (`article-frequence-bureaux-375/1440.jpg`)
- **Correspond** : en-tête, sommaire, corps, encadrés, vignettes des autres articles.
- **Statut proposé : À VALIDER**

### 9. Mentions légales (`mentions-legales-375/1440.jpg`)
- **Correspond** : structure et bandeaux.
- **Différence ASSUMÉE** : contenu réglementaire plus complet que la maquette (identification
  complète, hébergeur, médiation) — la page est **volontairement plus longue** ; c'est l'exception
  documentée depuis G20, à ne pas « corriger ».
- **Statut proposé : À VALIDER**

### 10. À propos (`a-propos-375/1440.jpg`)
- **Correspond** : hero avec le portrait **exact de la maquette** (fichier identique octet pour
  octet), bandes narratives.
- **Différence intentionnelle** : mention visible « Photo d'illustration provisoire — portrait
  d'Audrey à venir » — le visuel n'est jamais présenté comme Audrey (§5.6). La citation attribuée
  à Audrey reste à faire valider par l'intéressée avant mise en ligne (§5.5).
- **Statut proposé : À VALIDER**

### 11. Recrutement (`recrutement-375/1440.jpg`)
- **Correspond** : hero avec image exacte, bandes, renvoi vers le site carrière (aucun formulaire
  de candidature dupliqué, §8).
- **Statut proposé : À VALIDER**

### 12. Zoom — bande des six vignettes (`pilier-bande-vignettes-375/1440.jpg`)
- **Le changement G25 en gros plan** : six tuiles marine, chacune avec sa photo de prestation en
  miniature, ordre et cadrage de la maquette. L'en-tête visible dans certains panneaux pleine page
  est un artefact de capture (en-tête collant), neutralisé sur ce zoom.
- **Statut proposé : À VALIDER**

## Pour valider ou refuser

Répondre simplement, page par page ou globalement :
- « **Validé** » — la page correspond ;
- « **Refusé : <page> — <ce qui ne va pas>** » — la passe suivante corrige le point cité.

Aucune fusion ni déploiement n'aura lieu avant cette réponse.
