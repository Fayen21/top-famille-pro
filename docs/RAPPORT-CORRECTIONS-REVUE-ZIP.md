# Corrections après revue des trois ZIP — 25 octobre 2026

Revue de `dossier-passe-visuelle-1/2/3.zip`. Les corrections portent sur les sources (gabarits,
composants, CSS/JS sources, options, seeds, générateurs, champs ACF), jamais sur un export, une
capture ou un fichier minifié seul.

**Conclusion : PRET_POUR_VALIDATION_VISUELLE_HUMAINE.** La fidélité au prototype Claude Design
n'est pas déclarée validée : c'est une décision humaine.

## 1. Branche, HEAD, environnement

| | |
|---|---|
| Branche | `claude/jolly-fermi-d5dryq` (rien n'est fusionné dans `main`) |
| Point de départ | `7955f64`. `f516b6d` (passe visuelle du 14 octobre) et `f917741` (G27, 20 août) en sont des **ancêtres** : vérifié avec `git merge-base --is-ancestor` |
| Commits de cette passe | `edce393`, `b57761a`, `3f6478b`, `777e467`, `49e2d3c`, puis le commit du rapport (HEAD : voir `git log`) |
| Banc | WordPress (dépôt officiel, profondeur 1) + SQLite, `php -S` à 6 workers derrière `tools/banc-router.php`, PHP 8.3.6, Node 22.22.0, Playwright 1.62.1, Chromium préinstallé |
| Environnements | `development` pour la suite fonctionnelle (envoi d'e-mail neutralisé, `data-tfp-mail-disabled` vérifié avant toute soumission) ; `production` pour Lighthouse, l'export et les paquets — **aucun formulaire soumis en production** |
| Hors périmètre | aucun déploiement, aucune modification DNS, aucun envoi d'e-mail réel |

Points non rouverts, comme demandé : photo provisoire, citation d'Audrey, avis provisoires, note
Google (toujours masquée), « Kbis à confirmer » (pas un nouveau bloqueur).

## 2. Matrice des défauts

| # | Défaut (§ de la revue) | Cause vérifiée | Correction | Preuve |
|---|---|---|---|---|
| 1 | « Dans le même département » listait les autres départements sur Besançon, Auxerre, Belfort, Nevers, Vesoul (§2) | le générateur typait « départements » un groupe ne contenant que des départements, et le gabarit y rendait les sept autres | `tfp_zone_maillage()` (includes/cpt-zone.php) construit les groupes par **relations** (ID, département de la zone) : même département, communes proches, autres secteurs, sans la page courante ni un ID déjà lié | `tests/maillage.spec.js` (26 routes) ; captures `maillage-*-375` |
| 2 | Doublons Chalon/Mâcon, Dole/Lons, Beaune/Dijon entre groupes (§2) | listes « autres » reprises de la maquette, villes du même département comprises | même fonction, dédoublonnage dans l'ordre de la page | idem ; Chalon : autres = Dijon (21), Dole (39) |
| 3 | « Départements limitrophes couverts » (§2) | intitulé de la maquette | « Nos autres secteurs en Bourgogne-Franche-Comté » (generate-zones.mjs) | test département ×8, `docs/DECISIONS.json` `revue-trois-zip` |
| 4 | « À partir de 27 € HT/h » sur un tarif unique (§3) | libellé de `tfp_price_card()` | « Tarif unique » + « En régulier comme en ponctuel » | `corrections-zip.spec.js` ; `tarif-prestation-bureaux-*` |
| 5 | Ponctuel présenté en budget mensuel, « premier mois » (§3) | gabarit prestation à modèle mensuel par défaut (12 h) | champs ACF `exemple_mode` = intervention, `exemple_heures` = 7 : « intervention unique de 7 h · 189 € HT de main-d'œuvre », frais éventuels au devis ; « Déroulé d'une intervention type » | `ponctuel-*` ; test « ponctuel » |
| 6 | Volumes mensuels incohérents avec les passages (§3) | textes d'exemple de la maquette | 27 exemples réécrits par `EXEMPLES_CORRIGES` (compte vérifié à la génération), budgets officiels inchangés ; calcul centralisé `tfp_intervention_example()` | sortie du générateur : « 27 » ; balayage « par semaine » des 53 routes |
| 7 | « sans frais de déplacement » à Saint-Apollinaire (§3) | texte de la maquette | phrase des indemnités (0,35 €/km, majoration 10 %) | test dédié |
| 8 | Deux conclusions commerciales par page (§4) | pré-pied global + bande finale de page | `tfp_parcours()` / `tfp_cta_final()` : une seule conclusion | `tools/audit-conclusions.mjs` : 0 double sur 53 |
| 9 | Devis : barre et bandeau renvoyant au formulaire ouvert (§4) | barre mobile et pré-pied indifférents au parcours | aucune barre, pas de pré-pied ; CTA du header → `#tfp-formulaire-devis` | test « devis » ; `devis-etape1-*` |
| 10 | Recrutement : devis en action principale (§4) | barre mobile générique | candidature (site carrière) en primaire | test « recrutement » ; `recrutement-bas-375` |
| 11 | Contact et pages utilitaires : bande commerciale dominante (§4) | idem | contact : appel seul ; mentions, confidentialité, cookies, plan du site : aucune barre | test « contact et pages utilitaires » |
| 12 | Libellés d'appel disparates, numéro coupé, bouton entier en `nowrap` (§4) | libellés en dur, champ ACF de zone `cta_phone_label` | composant `tfp_bouton_appel()` : « Appeler Top-Famille Pro », numéro insécable, bouton qui passe à la ligne ; champ ACF vidé par le seed | test 320/375 px sur 5 routes |
| 13 | Icônes en caractères (☎ ✉ 📍 🕑 ＋) ; « + » visible menu ouvert (§5) | glyphes texte | jeu SVG `tfp_icone()` ; chevron qui suit `aria-expanded` | test tiroir |
| 14 | Tiroir mobile : petite hauteur, fermeture après navigation (§5) | lien interne ne fermait pas le panneau | `close(false)` au clic sur un lien ; défilement vérifié 375×560 et paysage | tests tiroir et seuils 819/820, 1099/1100, 1219/1220 |
| 15 | Index des prestations : six cartes à ≈ 2 600 px sur mobile (§5) | ordre de la maquette | section des cartes remontée sous le hero (`ORDRE_SECTIONS`, generate-pages.mjs) : 925 px à 375 | test « index des prestations » |
| 16 | Pied de page mobile ≈ 1 500 px (§5) | trois colonnes empilées | volets `<details>` natifs, ouverts côté serveur, repliés sous 820 px par JS ; marque, téléphone et liens légaux hors volet : 504 px | tests footer (JS et sans JS) ; `footer-375` |
| 17 | Étapes : espacement mobile, rangée tablette déséquilibrée (§5) | grille automatique 3 + 2 | 6 pistes en tablette (3 × 2 puis 2 × 3) ; pastille en ligne sur mobile, police inchangée (18 px) | test « étapes » ; `etapes-375`, `etapes-768` |
| 18 | Carte : contraste des limites, légende, titre (§5) | filet turquoise ≈ 1,6:1 ; légende centrée sur trois lignes | filet bleu principal ; légende en deux lignes (siège, départements couverts) ; titre « Une entreprise régionale basée à Saint-Apollinaire » (autorisé par la revue) ; chapeau : huit départements, même tarif horaire, organisation au devis | test « carte » ; `carte-*` ; `docs/ECARTS-MAQUETTE-AUTORISES.md` |
| 19 | « 21540 » présenté comme code postal (§5) | rapport précédent | « code INSEE 21540 ; code postal 21850 » | `docs/RAPPORT-PASSE-VISUELLE.md` |
| 20 | Fonction de gérante répétée trois fois dans le même bloc (§5) | titre + paragraphe + signature | paragraphe sans répétition | `gerante-375` |
| 21 | Photos de villes : `alt` affirmant un lieu (§5) | `alt` relevé de la maquette | « Locaux professionnels (photo d'illustration) » (generate-zones.mjs, optimize-images.mjs) | test « photos de villes » |
| 22 | Pilier : « Ce que vous gardez la main sur », passage dédoublé (§6) | texte de la maquette | « Ce sur quoi vous gardez la main » ; doublon retiré (`CORRECTIONS_EDITORIALES`) | test « pilier » |
| 23 | « Exemples de budgets réels » (§6) | texte de la maquette | « Exemples de budgets » (generate-articles.mjs) | test « article coût » |
| 24 | Contact : « Horaires indicatifs, en cours de confirmation » (§6) | amplitude de la maquette jamais établie | carte « Disponibilité » : réponse sous 24 h, interventions du lundi au samedi 6 h – 22 h (PROJECT_INPUTS.md) ; aucune `openingHours` | `tests/contact.spec.js` |
| 25 | Cookies : « Outil retenu : à confirmer » (§6) | note de travail | supprimée | `DECISIONS.json` |
| 26 | Confidentialité : devis et contact confondus, candidatures (§6) | texte générique | deux rubriques (devis : téléphone OU e-mail ; contact : nom, e-mail, objet) ; candidatures sur le site carrière externe | test « confidentialité » |
| 27 | « Un devis pour Bureaux » (§6) | titre de CPT injecté tel quel | champ ACF `objet_editorial` : « Un devis pour le nettoyage de vos bureaux ? » | test « titres de prestation » |
| 28 | Formulations défensives répétées (§6) | même réserve sur plusieurs cartes | réserve dite une fois (FAQ « intervenant habituel ») | seed des pages |
| 29 | Accueil 1440 : images blanches dans la capture (§7) | **outil** : la pleine page était prise sans défilement, les images `loading="lazy"` n'étaient jamais demandées. Prouvé en recapturant le thème `7955f64` avec l'outil corrigé : 12/12 images chargées | `tools/lib/capture-fiable.mjs` : polices, défilement progressif, `decode()`, stabilité. Aucune image rendue « eager » | `bilan.json` avant et après : 0 image non chargée |
| 30 | Formulaire : « téléphone OU e-mail » et code postal non vérifiés côté client ; code postal non vérifié côté serveur (§8) | `validateStep()` ne lisait que `[required]` | règles client en français + `aria-invalid` + focus sur le premier champ fautif ; garde serveur sur le code postal | `tests/functional/quote-form.spec.js` (15 tests) |
| 31 | Formulaire : focus forcé au chargement (lu sur la revue) | `showStep()` au démarrage | focus seulement au changement d'étape | revue `demande-de-devis-375` |
| 32 | Sommaires d'articles en texte seul ; cible sous le header (§8) | entrées sans lien ; `scroll-margin-top` 110/88 px pour un header de 120/101 px | ancres uniques sur les H2, liens, décalage 136/116 px | test sommaires (3 articles × 2 largeurs) |
| 33 | Filtres Conseils sans comportement (§8) | pastilles inertes, dont une « active » | boutons `aria-pressed` ajoutés par JS (liste statique sans JS), région live | test filtres ; Lighthouse a11y 100 |
| 34 | Bouton d'appel replié : « · » en tête de ligne (lu sur les captures) | séparateur en pseudo-élément | séparateur supprimé, numéro distingué par la graisse | `menu-mobile-bas-375x560` |
| 35 | Pied : icône téléphone sur sa propre ligne (régression de cette passe) | SVG en bloc | lien en `inline-flex` | `recrutement-bas-375` |

## 3. Fichiers et champs ACF modifiés

- **Thème** : `includes/` (components, cpt-zone, site-options, quote-form, reassurance-settings,
  acf-fields-prestation), `single-zone.php`, `single-prestation.php`, `single.php`, 17 gabarits de
  page, `template-parts/` (header, mobile-nav, mobile-cta-bar, footer, static-blocks, home/*),
  `src/css/04-components.css`, `src/css/05-home.css`, `src/js/{nav,quote-form,conseils-filtres,main}.js`.
- **ACF prestation** (nouveaux) : `objet_editorial`, `exemple_mode`, `exemple_heures`.
- **ACF zone** : `cta_phone_label` vidé par le seed (le composant porte le libellé) ; `hero_alt`.
- **Générateurs** : `generate-zones.mjs`, `generate-prestations.mjs`, `generate-pages.mjs`,
  `generate-articles.mjs`, `build/optimize-images.mjs` ; seeds régénérés et copiés dans
  l'installeur.
- **Outils** : `lib/capture-fiable.mjs`, `captures-corrections.mjs`, `audit-conclusions.mjs`,
  `dossier-revue-zip.mjs`, `revue-visuelle.mjs` (préparation fiable), `lighthouse.mjs` (3 pages
  ajoutées), `decouper-image.mjs`, `lister-maillage-seed.py`.
- **Décisions** : `docs/DECISIONS.json` (`revue-trois-zip`, vérifiée sur les 53 routes servies),
  `docs/ECARTS-MAQUETTE-AUTORISES.md` (titre de la couverture, état antérieur archivé).

## 4. Captures

- **Avant / après** : `docs/captures-corrections/{avant,apres}/` — 44 vues chacune : les 10
  maillages, les 8 blocs départementaux, tarif, exemples, ponctuel, devis (étapes 1 et 2),
  recrutement, contact, mentions, menu mobile (375×812 et 375×560), pied, étapes 375/768, carte
  375/1440, gérante, index des prestations, accueil complet 375 et 1440. `bilan.json` : 0 image
  rendue non chargée des deux côtés.
- **Fenêtre ou composant** : une capture « composant » remet l'en-tête collant dans le flux et
  masque la barre mobile (`figerCouches()`), pour que rien ne traverse le composant ; une capture
  « fenêtre » (menu mobile, accueil) montre le comportement réel des couches fixes. Le mode est
  écrit dans `bilan.json` pour chaque vue.
- **53 routes à 375 et 1440** : `docs/revue-visuelle/` (110 pleines pages, 502 tuiles lisibles),
  relevé `docs/REVUE-VISUELLE.md` : 106 écrans sans défaut objectivable. Tuiles relues à la main,
  dont des pages internes à 1440 (ponctuel, contact, Besançon) : trois défauts y ont été trouvés et
  corrigés (#31, #34, et « 6 h » coupé sur Contact).

## 5. Tests (banc local)

| Contrôle | Résultat | Commit |
|---|---|---|
| `npm run lint:php` | 83 fichiers, 0 erreur | `149acd6` |
| `npm run build` | CSS/JS + images | `3f6478b`, CSS/JS reconstruits à chaque commit suivant |
| Suite Playwright complète, `development` | 1 362 / 1 363 — l'échec est la limitation de fréquence, voir §5 bis | `149acd6` |
| Suites ciblées : maillage (26), corrections-zip (30), functional (15), contact, décisions, fidélité, passe-visuelle, accessibilité | vertes | `777e467` puis final |
| Lighthouse, 10 pages × mobile/bureau, `banc-production.mjs` | 20/20 au-dessus des cibles (perf ≥ 97, a11y/BP/SEO 100, LCP mobile ≤ 1,98 s, CLS 0) | `49e2d3c` |
| Export statique + `--verifier` | 53/53 routes hors ligne, 0 image cassée, 0 requête externe | `49e2d3c` (seul `style.css` a changé depuis : version 0.14.0) |
| Paquets + parité dépôt ↔ livraison | 1 267 fichiers concordants | reconstruits après le passage en 0.14.0 |
| Dossier hors ligne, extrait à neuf, réseau coupé | conforme | `149acd6` |

**Lighthouse** : mesuré sur le banc local derrière un mandataire qui ajoute compression et cache
comme LiteSpeed. Ce n'est **pas** une mesure Hostinger : le serveur réel (TTFB, cache LiteSpeed
effectif) reste à mesurer après déploiement.

### 5 bis. Suite complète sur le HEAD final

Exécutée sur le commit `149acd6` (code identique au HEAD : le commit suivant ne touche que
`docs/` et les captures de référence), banc en `development`, du 2026-10-25T16:30:18Z au
2026-10-25T16:39:29Z : **1 362 réussis, 1 échec**.

L'échec est `quote-form.spec.js` « soumission complète (téléphone seul) » : le serveur a répondu
`erreur=limite`. C'est la **limitation de fréquence** (5 demandes par heure et par IP) qui a
joué son rôle : plusieurs fichiers de la suite et les relances de la journée soumettent depuis la
même adresse. Après purge des transients du banc (`wp transient delete --all`), le fichier
fonctionnel relancé seul passe : **15/15**. Aucun e-mail réel n'est parti (`data-tfp-mail-disabled`
vérifié avant chaque soumission).

Lint PHP sur le même commit : 83 fichiers, 0 erreur.

## 6. Livrables

- `release/paquets-travail-2026-10-25/` : thème, installeur, HTML brut, site navigable ;
  `SHA256SUMS.txt`.
- `release/dossier-revue-zip-2026-10-25-volume-1-avant-apres.zip` et `…-volume-2-53-routes.zip` ;
  `release/SHA256SUMS-dossier-revue-zip.txt`. Vérifiés par
  `tools/verifier-dossier-hors-ligne.mjs` après extraction dans un répertoire neuf.
- Les archives antérieures de `release/` sont marquées **anciennes** dans
  `release/LISEZ-MOI-ARCHIVES.md`.

## 7. Limites

- Mesures de performance locales uniquement (voir §5).
- La lecture humaine des 110 pleines pages n'a pas été exhaustive tuile par tuile : un échantillon
  a été lu ; le reste est couvert par le relevé automatique (débordements, textes coupés, cibles,
  images non chargées, erreurs console).
- Restent hors de cette passe, par consigne : photo et citation d'Audrey, avis provisoires, note
  Google, données d'immatriculation (Kbis).
