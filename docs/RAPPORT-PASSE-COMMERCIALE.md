# Passe commerciale — 10 et 11 novembre 2026

Objectif : rendre le site plus convaincant, plus concret et plus facile à parcourir, sans le
reconstruire. Les corrections de `RAPPORT-CORRECTIONS-REVUE-ZIP.md` sont préservées (maillage,
carte SVG, cinq étapes, portrait, footer compact, CTA par parcours, URLs, SEO).

**Statut : PRET_POUR_VALIDATION_VISUELLE_HUMAINE.** Le rendu n'est pas validé par ce rapport.

## 1. Branche, commits, environnement

| | |
|---|---|
| Branche | `claude/jolly-fermi-d5dryq` — rien n'est fusionné dans `main`, rien n'est déployé, aucun DNS modifié |
| Point de départ | `6102180` (code identique à `b095763` ; `b095763` et `4514c34` en sont des ancêtres, vérifié) |
| Code livré | **`b8d3bef`** — thème **0.15.0**. Le commit qui porte ce rapport n'ajoute que de la documentation et des archives |
| Banc | WordPress + SQLite sous `php -S` (`tools/banc-local.sh`), PHP 8.3, Node 22, Playwright 1.62, Chromium préinstallé |
| Environnements | `development` pour les tests (envoi d'e-mail neutralisé) ; `production` + mandataire de compression (`tools/banc-production.mjs`) pour Lighthouse, l'export et les paquets |

## 2. Changements réalisés

### Premier écran et header (§2, §8)
- H1 « Nettoyage professionnel en Bourgogne-Franche-Comté », bénéfice en une phrase, publics en une
  ligne. Le tarif de 27 € HT/h, « Demander mon devis », « Appeler Top-Famille Pro » et la réassurance
  courte forment un seul bloc.
- Retirés car redondants : la pastille de prix posée sur la photo et le bandeau tarifaire placé juste
  sous le hero. La grille de réassurance passe de 5 à 4 cartes, sans délai ni tarif répétés. Elle
  garde « Frais et conditions d'arrêt précisés au devis ».
- À 375 × 812 px, le tarif et les deux commandes tiennent dans le premier écran, au-dessus de la
  barre mobile. Les polices ne sont pas réduites (texte d'introduction à 17 px).
- Descriptif « Nettoyage de locaux professionnels » à côté du logo de 370 à 1 099 px, et dans la
  barre haute à partir de 1 100 px, où la navigation touche le logo. Absent sous 370 px pour ne pas
  pousser le menu hors champ ; ce défaut avait été relevé sur une capture puis corrigé.
- Fichiers : `template-parts/home/hero.php`, `pricing-reassurance.php`, `pricing.php`,
  `template-parts/header/site-header.php`, `src/css/05-home.css`, `04-components.css`.

### Images (§3)
- Accueil : la scène de nettoyage passe au premier plan (source 1 000 px). L'espace de bureaux devient
  la vignette.
- Cabinets : salon d'accueil avec fauteuils, de type salle d'attente.
- Copropriétés : couloir de circulation, à la place du salon de bureaux.
- Les textes alternatifs décrivent la photo réelle, toujours « (photo d'illustration) ». Ils ne
  décrivent plus la prestation (`build/optimize-images.mjs`, `single-prestation.php`).
- Conservés : AVIF/WebP, `srcset`, dimensions, `fetchpriority` sur l'image principale seule,
  lazy-loading ailleurs. Les variantes 1040 et 1200 px orphelines ont été supprimées.

### Prestations, pilier et pages locales (§4, §5, §7)
- Gabarit prestation (`single-prestation.php`), commun aux six prestations. Ordre : sommaire
  « Sur cette page », l'essentiel (publics, tâches, hors prestation), organisation des passages
  (semaine type, configurations), tarif et périmètre, exemple de suivi, limites et exclusions, puis
  « Dans le détail » en volets `<details>`. Ces volets s'ouvrent au clavier et sans JavaScript, et le
  contenu reste dans le HTML.
- Retirés de l'affichage, données ACF conservées :
  - le bloc d'organisation « Suivi », remplacé par l'exemple de suivi ;
  - la carte tarifaire de la colonne « Pour qui », le tarif ayant désormais sa propre section.
- **Exemple de suivi** (`tfp_exemple_suivi()`) : il explique d'abord les deux documents — le cahier
  des charges définit ce qui est prévu, le cahier de liaison suit ce qui est réalisé.
  - Tableau de quatre lignes : tâche, fréquence, passage, observation. Il devient une fiche par
    ligne sous 640 px.
  - Titré « Exemple de suivi », avec la mention « il ne reproduit le dossier d'aucun client ».
  - Lignes propres à chaque prestation, dans le champ ACF `suivi_exemple` (`generate-prestations.mjs`).
- **Périmètre du tarif** (`tfp_perimetre_prix()`) : inclus / fourni par le client / au devis
  lorsqu'ils s'appliquent. Règles inchangées : 27 € HT/h, gestion 9 € HT/mois, mise en place
  50 € HT, 0,35 € HT/km, +10 %. Sur le ponctuel, la gestion mensuelle n'est pas citée. Il est
  présent sur les prestations et l'accueil. Les exemples 225/333/549 € HT, les premiers mois
  275/383/599 € HT et les 189 € HT du ponctuel sont inchangés.
- **Pages locales** (`single-zone.php`) :
  - restent ouverts : l'implantation, les professionnels accompagnés et les fréquences, qui portent
    les particularités du secteur ;
  - passent en volets : les chapitres génériques (tâches par type de local, horaires et matériel,
    clés, sélection et suivi) ;
  - le maillage est inchangé.
- **Pilier** : sommaire vers 12 sections, et trois sections de méthode repliées (tâches, cahier des
  charges, construction du cahier). Implémenté dans `static-blocks.php` (`replier`) et
  `tfp_static_sommaire()`.
- **Ton factuel** :
  - 11 tournures défensives remplacées dans les zones, 1 dans les prestations, 3 dans les pages.
    Dijon : « Basée à Saint-Apollinaire, notre entreprise organise les interventions à Dijon et dans
    son agglomération. »
  - Les limites de couverture sont conservées, formulées autrement.
  - Le générateur échoue si une phrase cible disparaît.

| Page | Hauteur avant → après, 375 px | 1440 px |
|---|---|---|
| Bureaux | 13 257 → 10 969 | 7 755 → 7 345 |
| Dijon | 13 634 → 10 092 | 8 323 → 6 570 |
| Pilier | 18 793 → 15 636 | 11 004 → 9 986 |
| Accueil | 12 063 → 11 884 | 7 619 → 7 638 |

Aucun nombre de mots n'a été fixé, et aucun texte utile n'a été supprimé du HTML.

### Formulaire de devis (§6)
- L'étape 1 garde type de locaux, régime, ville, nom, téléphone et e-mail. Le code postal et la
  surface passent à l'étape 2, avec la mention « (facultatif) ».
- La prestation n'est plus redemandée : un champ caché est prérempli depuis la page d'origine ou le
  type de locaux choisi.
- Le résumé de l'étape 2 reprend type, régime, ville, nom et contact, avec « Modifier l'étape 1 ».
- Règles conservées : téléphone OU e-mail, code postal vide ou de 5 chiffres (client et serveur),
  nonce, honeypot, consentement, UTM, anti-double-envoi, limitation de fréquence (5/h/IP),
  confirmation accessible. Aucun gain de conversion n'est annoncé.

### Export navigable (§9)
- `tools/export-statique.mjs` : dans le paquet navigable seulement, les formulaires visent
  `demonstration-formulaire.html` en GET. Ils portent `data-tfp-demo` et une mention
  « Mode démonstration », et perdent `data-tfp-analytics`.
- `demonstration-formulaire.js` laisse jouer les étapes et la validation du thème, puis affiche une
  **confirmation annoncée comme simulée**. Le point d'envoi WordPress de production n'est pas
  modifié.
- Contrôle automatique à chaque export : 0 POST, 0 événement de conversion, 0 page visant encore
  `admin-post`.

## 3. Captures

`docs/captures-passe-commerciale/{avant,apres}/` : 16 vues × 375 et 1440 px. Elles couvrent :
- le premier écran et la page complète de l'accueil, le header ;
- les héros des six prestations, la page Bureaux complète, l'index des prestations ;
- Dijon, le pilier et les tarifs ;
- les deux étapes du devis.

Pour l'après, toutes les images sont chargées (`bilan.json`). Dossier hors ligne :
`release/dossier-passe-commerciale-2026-11-11-avant-apres.zip`, vérifié après extraction dans un
répertoire neuf, réseau coupé.

Lues à l'œil : accueil 375/1440, header, Bureaux (375 en tranches, tarif et suivi à 1440),
copropriétés et cabinets, devis étapes 1 et 2. Trois défauts concrets y ont été trouvés puis
corrigés :
- menu poussé hors champ à 375 px ;
- « ; » orphelin en début de ligne ;
- phrase inexacte sur les champs facultatifs.

## 4. Tests réellement exécutés

| Contrôle | Résultat |
|---|---|
| `npm run lint:php` | 83 fichiers, 0 erreur |
| `npm run build` (CSS, JS, images) | OK |
| Suite Playwright complète (`development`, commit `466adbc`, code identique à `b8d3bef` pour le thème hors numéro de version) | **1 383 réussis, 1 échec** : la parité installeur, avant reconstruction des paquets ; rejouée ensuite : **4/4** |
| Tests de la passe (`tests/passe-commerciale.spec.js`, 17) et du formulaire (`tests/functional`, 17) | verts |
| Revue des gabarits touchés à 320, 375, 768, 1024, 1440, 1920 px (`tools/revue-visuelle.mjs`, 10 routes, 60 écrans) | 0 alerte après correction de l'en-tête masqué du tableau de suivi |
| Lighthouse, 11 pages × mobile/bureau, `production` + mandataire de compression local | **22/22 au-dessus des cibles** : perf. mobile 99–100, a11y/BP/SEO 100, LCP mobile ≤ 1,97 s, CLS 0 |
| Export statique + vérification | 53/53 routes hors ligne, 0 image cassée, 0 requête externe, démonstration OK |
| Paquets + parité dépôt ↔ livraison | 1 258 fichiers concordants |

Tests mis à jour parce qu'ils figeaient l'ancienne présentation, voulue ici différente :
- H1 et bandeau de l'accueil (`fidelite`, `passe-visuelle`) ;
- ordre de tabulation de l'étape 1 (`accessibility`) ;
- grille « détail » du gabarit prestation (`g23`) ;
- champ « fonctionnement » lu dans un volet replié (`fonctionnement-acf`, en `textContent`) ;
- carte tarifaire de la prestation (`corrections-zip`).

## 5. Limites et ressources à fournir

- **Photos**. Le réseau de la session n'atteint aucune banque d'images. Un environnement autorisant
  Openverse et Wikimedia (« top-famille-pro ») a été créé, mais cette session ne pouvait pas y
  basculer. Restent à fournir, sous licence permettant l'usage commercial ou en photo réelle :
  - **copropriétés** : hall, escalier ou palier d'immeuble résidentiel ;
  - **bureaux** : une scène d'entretien d'un poste de travail, la photo actuelle montrant un open-space
    occupé ;
  - **ponctuel** : une scène de remise en état distincte, l'image actuelle étant la même que celle de
    l'accueil ;
  - **meublés** : un logement préparé (lit fait, linge), la photo actuelle montrant une cuisine ;
  - **accueil** : une scène de nettoyage avec moins d'équipement de protection, si possible.
- Lighthouse n'a été mesuré que sur le banc local : aucune mesure Hostinger.
- Le descriptif métier n'apparaît pas sous 370 px de large.
- Inchangés, par consigne : photo temporaire et citation d'Audrey, avis provisoires, note Google
  masquée, données Kbis.
