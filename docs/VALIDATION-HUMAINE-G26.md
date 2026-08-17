# Validation humaine — passe G26

> Fiche de décision pour la relecture des captures, après le **refus** du 17 août 2026.
> **Rien n'est validé d'office** : chaque page reste « À VALIDER » tant qu'Emmanuel ou Audrey ne
> l'a pas tranché.
>
> **Comment relire.** Ouvrir `index.html` du volume 1 dans un navigateur — tout fonctionne hors
> ligne, sans serveur ni connexion. Chaque image montre, de gauche à droite : la maquette Claude
> Design, le rendu WordPress, puis le **panneau de différence**.

## Ce qui a changé dans la façon de lire le troisième panneau

C'était le premier motif du refus : « le troisième panneau est pratiquement uniforme malgré des
différences majeures ». C'était exact, et la cause est identifiée — l'ancien générateur inversait
l'image de différence, ce qui ramenait tout écart faible à du blanc.

Le panneau a été refait. Désormais :

- l'écart est **amplifié ×8** et rendu en **magenta** : un écart de deux niveaux devient visible ;
- un **bandeau** en haut du panneau écrit l'amplification appliquée **et** la proportion de pixels
  qui s'écartent ;
- deux captures de largeurs différentes sont **refusées**, au lieu d'être superposées.

Concrètement : **un panneau sans couleur veut maintenant dire quelque chose** — et le taux affiché
le confirme. Ce n'est plus une absence d'information.

Cette réparation est éprouvée par un test (`tests/diff-visuel.spec.js`) construit sur une image
volontairement différente de sa jumelle à un carré près. L'ancien générateur est conservé et passé
aux mêmes contrôles : **il échoue**. La démonstration est faite, pas affirmée.

## État technique au moment de la relecture

| Contrôle | Résultat |
|---|---|
| Suite de tests | **1063 verts**, 0 échec |
| Images comparées par empreinte sur les 53 routes | **164 · 0 écart** |
| Relevé de base, 6 largeurs | 318 contrôles · 298 dans 95-105 % · **0 débordement** · 0 erreur console |
| Lighthouse, 7 routes × mobile/bureau | **14 mesures, 0 sous la cible** · accessibilité 100 partout |
| CLS | maximum 0,0048 |
| WCAG 2.2 AA — cibles tactiles | aucune violation |
| Note Google non vérifiée, compteur d'avis, `Review`, `AggregateRating`, `href="#"` | **0 occurrence** sur les 53 routes |

La fidélité **n'est pas** déclarée validée pour autant : c'est l'objet de cette relecture.

---

## Pages prioritaires — ce qui a changé depuis le refus

### 1. Accueil
- La **note Google n'est plus affichée** : tant que l'URL de la fiche n'est pas fournie, elle ne
  peut pas être vérifiée par un visiteur. Elle reviendra d'elle-même le jour où l'URL sera saisie.
- Le **compteur d'avis** du prototype, qui revenait par le contenu, est bloqué.
- La **vignette d'auteur** du témoignage (44 px, ronde) est rétablie ; elle n'apparaît que sur un
  témoignage provisoire, avec un `alt` vide et le nom écrit à côté.
- Les **photos des deux cartes de prestation** étaient celles des pages de prestation ; ce sont
  maintenant celles que la maquette pose sur l'accueil.

### 2. Page pilier
- Les six vignettes 56 px de G25 sont **conservées** et toujours éprouvées.
- Le **visuel de la bande « Cahier des charges, intervenants et suivi »** manquait : il est rétabli.
- Les intertitres retrouvent les tailles du prototype (17 à 40 px selon la bande).

### 3. Prestation (bureaux)
- Le visuel de hero était **croisé** avec celui d'une page de ville. Les six prestations ont
  désormais chacune sa photo, celle de la maquette, appariée sur les octets.

### 4. Ville (Dijon)
- Chaque ville a la photo que la maquette lui donne ; le thème servait la même partout.

### 5. Tarifs
- La note Google n'y figure plus (voir accueil).

### 6 et 7. Formulaire, étapes 1 et 2
- Les deux captures sont faites avec **exactement les mêmes données** des deux côtés, l'étape 2
  vérifiée atteinte des deux côtés avant déclenchement, même défilement, même neutralisation de
  l'en-tête.
- **Ce dossier n'affirme plus « mêmes champs ».** Les différences fonctionnelles qui subsistent —
  jeton, piège à robots, champs de contexte, contrôles obligatoires — sont listées une par une dans
  `FORMULAIRE-DIFFERENCES.md`, avec leur motif. Les valeurs réellement saisies des deux côtés sont
  dans `FORMULAIRE-CAPTURES.md`.
- Un défaut réel a été trouvé au passage : un **double clic produisait deux demandes**. Corrigé.

### 8. Article
- Aucun changement de fond ; le faux écart d'image signalé par l'audit venait de l'audit lui-même.

### 9. Mentions légales
- Inchangé : contenu réglementaire réel, plus long que la maquette. **Écart assumé.**

### 10. À propos — l'un des motifs du refus
- **Ordinateur** : image à gauche, contenu à droite (c'était l'inverse).
- **Mobile** : image avant le texte (c'était après).
- **Citation** : dans sa bande pleine largeur, avec sa typographie ; elle se fondait dans la page.
- **Attribution** : « Audrey · Top-Famille Pro » sur une seule ligne.
- **Quatre valeurs** : la mention « exemples de présentation » qui les coiffait à tort est retirée —
  ce sont les valeurs de l'entreprise, pas des témoignages.
- **Commandes** : deux rangées de boutons au lieu de six lignes de texte, et le bouton
  « ☎ Parler de mes locaux avec Audrey » est rétabli — il avait purement disparu.
- Le portrait reste signalé comme illustration provisoire.

### 11. Recrutement — l'autre motif du refus
- Le hero portait « Demander mon devis » et « Appeler Audrey ». Il porte maintenant
  **« Envoyer ma candidature »** et le **numéro en clair**, comme la maquette.
- La candidature mène au **site carrière**, comme `CLAUDE.md` §8 l'impose. Aucun second formulaire
  n'a été créé.
- Le **panneau des étapes** est marine, comme dans la maquette ; il était blanc.
- Les trois étapes redeviennent une liste numérotée.

### 12. Zoom — bande des six vignettes du pilier
- Régénérée avec le panneau de différence réparé.

---

## Deux points TRANCHÉS le 17 août 2026

Ces deux points vous avaient été soumis ; vous avez répondu **« garde les CTA et l'entrée du
menu »**. Ils sont donc conservés, inscrits au registre des écarts assumés
(`ECARTS-MAQUETTE-AUTORISES.md` §7 et §8) et **verrouillés par un test**
(`tests/ecarts-structure.spec.js`) : une passe ultérieure qui les « corrigerait » au nom de la
fidélité fera échouer la suite et devra revenir au registre plutôt que de trancher à nouveau.

### A. Navigation principale — sept entrées contre six

| Maquette | Site |
|---|---|
| Prestations ▾, Tarifs, Zones ▾, Pourquoi nous, Avis, Conseils | Prestations ▾, Zones ▾, **Nettoyage professionnel**, Nos tarifs, Pourquoi nous, Avis clients, Conseils |

La barre passe à la ligne à 1440 px et l'en-tête gagne 22 px sur les 53 pages. Retirer la page
pilier du menu améliorerait la fidélité mais c'est un **arbitrage de référencement** : cette page
est la porte d'entrée du site sur « nettoyage professionnel ».

**Décision : l'entrée est CONSERVÉE.** Coût accepté : en-tête +22 px sur les 53 pages.

### B. Commandes dans le hero de cinq pages institutionnelles

La maquette ne pose pas de commandes dans le hero de `/a-propos/`, `/pourquoi-nous/`,
`/notre-fonctionnement/`, `/avis-clients/` et `/prestations/`. Le site en pose deux.

Le **badge région** relevait du même constat sur sept pages : il a été retiré, c'est décoratif. Les
commandes, elles, sont des points de conversion — les retirer est une décision commerciale.

**Décision : les commandes sont CONSERVÉES.** Le badge région, lui, reste retiré — c'était
décoratif, et la décision ne portait que sur les commandes.

---

## Ce qui reste bloquant pour une mise en ligne

Inchangé depuis les passes précédentes, et indépendant de cette relecture :

1. **Données d'immatriculation non confirmées par Kbis** — bloqueur, rien ne se publie avant.
2. **Nombre réel d'avis Google et URL de la fiche** — sans eux, la note reste retirée.
3. **Photo authentique d'Audrey** — les portraits sont des visuels d'illustration déclarés.
4. **Citation attribuée à Audrey** — à valider par l'intéressée avant mise en ligne.
5. **Huit communes secondaires** en `noindex,follow` tant qu'Audrey ne les a pas validées une par
   une.

## Un point de documentation à arbitrer

`CLAUDE.md` §5.5 énonce toujours que la note de 5,0/5 est confirmée et affichable. La consigne de
cette passe demande de la retirer tant qu'aucune vérification officielle n'est fournie. Les deux
sont contradictoires. `CLAUDE.md` portant la consigne de ne pas être modifié sans votre validation,
la contradiction est **signalée** plutôt que corrigée.

---

## Verdict proposé

**`PARTIEL — ÉCARTS RESTANTS`**, et il le restera jusqu'à votre validation des captures.

Les deux points de composition sont désormais tranchés ; ce qui reste bloquant est la liste
ci-dessus — données d'immatriculation non confirmées par Kbis au premier rang.
