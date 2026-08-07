# Données fictives à neutraliser avant publication

> Inventaire des données de démonstration présentes dans le prototype (`reference/Top-Famille-Pro-HANDOFF-READY.html`),
> localisées par extraction du bundle (objets `RATING`, `REVIEWS`, `PILLAR_REVIEW`, `SERVICES[].review`,
> `GEO2[id].review`, `CITIES/SECONDARY[].scenario`). Le prototype **sait lui-même** qu'il s'agit de
> démonstration : chaque avis porte un champ `demo: true` et un commentaire de code dédié — ce n'est
> pas une supposition de cet audit, c'est déclaré dans les données.
>
> Référence CLAUDE.md : §5.5 (preuves), §5.6 (images), §9 (corrections éditoriales imposées).

---

## 1. Note et compteur d'avis Google — à masquer entièrement

Objet centralisé `RATING`, avec un commentaire du prototype qui dit explicitement de ne pas le
publier tel quel :

```js
// ratingDemo/reviewCountDemo = true : valeurs de démonstration, à confirmer avant publication
const RATING = {
  ratingDemo: true, rating: 5.0, ratingDisplay: '5,0',
  reviewCountDemo: true, reviewCount: 47,
  googleUrl: '#', // à confirmer : lien vers la fiche Google réelle
};
```

- **Note 5,0/5** — fictive.
- **Compteur « 47 avis »** — fictif.
- **`googleUrl: '#'`** — lien mort volontaire, à ne jamais publier tel quel (`href="#"` public interdit, CLAUDE.md §8).
- Utilisé dans le hero (badge de réassurance) et sur `/avis-clients/` : CLAUDE.md §9 rappelle de
  « ne pas répéter la note Google sur l'accueil : une preuve dans le hero + une section avis suffisent »
  — mais tant que la note réelle n'est pas fournie (PROJECT_INPUTS.md question ouverte #6), **le
  bloc entier doit être masqué**, pas seulement dédoublonné.

**Action phase 1+ :** masquer tout composant de note/compteur tant que Emmanuel/Audrey n'ont pas
fourni l'URL de fiche Google, la note réelle et le nombre réel d'avis.

---

## 2. Avis clients fictifs — 40 occurrences au total, toutes à supprimer

Décompte exact reconstitué depuis les données du prototype :

| Source | Nombre | Détail |
|---|---|---|
| `REVIEWS` (page Avis clients) | 6 | Camille R. (Dijon), Thomas L. (Besançon), Sarah B. (Dole), Nadia M. (Chalon-sur-Saône), Julien P. (Auxerre), Olivier D. (Besançon) |
| `SERVICES[].review` (une par prestation) | 6 | Un avis démo par page prestation (bureaux, commerces, cabinets, copropriétés, meublés, ponctuel) |
| `PILLAR_REVIEW` (page pilier « Nettoyage professionnel ») | 1 | Marc V., Directeur administratif, Chalon-sur-Saône |
| `REGION_PAGE.review` (page région Bourgogne-Franche-Comté) | 1 | Sophie M., Cabinet comptable, Côte-d'Or |
| `GEO2[id].review` (8 départements + 10 villes + 8 communes) | 26 | Un avis démo par page géographique |
| **Total** | **40** | Correspond exactement à l'« ~40 avis fictifs » signalé par CLAUDE.md §5.5 |

Tous portent `demo: true`, une note à 5, une source « Google » et une date fictive (« mars 2026 »,
« février 2026 »…). Aucun de ces 40 avis ne correspond aux six témoignages authentiques listés
dans CLAUDE.md §5.5 (Jean-Louis D., Anna P., Michel G., Laurent, Laura, Anne-Sophie) — **ne jamais
les faire correspondre entre eux**, ce sont des avis B2C Top-Famille, pas des avis B2B Top-Famille Pro.

**Photo associée :** `assets/photos/avatar-avis-demo.jpg` — avatar générique utilisé pour illustrer
ces avis de démonstration. À supprimer avec les avis, ou à conserver uniquement comme silhouette
neutre non associée à un nom si un jour un système d'avis anonymisé est voulu (hors périmètre actuel).

**Action phase 3 :** suppression totale des 40 avis de démonstration sur toutes les pages
concernées. Remplacement uniquement par les 6 avis authentiques (CLAUDE.md §5.5), affichés sans
prétendre à une couverture systématique par page/ville/prestation qu'ils n'ont pas.

---

## 3. Concurrents cités par erreur — à vérifier

`PROJECT_INPUTS.md` §10 liste des concurrents relevés sur Google Places (France Nettoyage 21,
1 PEK, Prop'Vert, Audacès Propreté) à titre de veille marché — **ce ne sont pas des données à
publier sur le site**, seulement du contexte pour Emmanuel/Audrey. Vérifier qu'aucune page du
prototype ne les mentionne par erreur (aucune occurrence trouvée à ce jour dans le bundle).

---

## 4. Scénarios locaux « exemples de besoin » — hypothétiques, à conserver avec prudence

18 pages géographiques (10 villes + 8 communes) portent un champ `scenario` avec `scenarioDemo: true` :
un paragraphe d'exemple explicitement hypothétique (« Exemple de besoin pouvant être étudié : … »),
illustrant un cas d'usage plausible pour la ville. Exemple (Dijon) :

> « Exemple de besoin pouvant être étudié : une PME d'une vingtaine de salariés installée dans un
> secteur tertiaire de l'agglomération peut demander un passage de 2 heures, plusieurs matins par
> semaine, avant l'arrivée des équipes… »

Ce ne sont **pas** des témoignages ni des faits affirmés (le conditionnel « peut demander » et le
préfixe « exemple pouvant être étudié » évitent l'usurpation) — contrairement aux avis de la
section 2, ils ne prétendent pas décrire un client réel. Mais CLAUDE.md §5.1 interdit d'inventer une
« fréquence locale » ou un « délai opérationnel » : ces scénarios frôlent la limite en donnant des
fréquences précises (« plusieurs matins par semaine ») attachées à une ville précise, sans source.
**À trancher en phase 3** : soit les garder en généralisant la formulation (aucune fréquence
chiffrée attribuée à une ville en particulier), soit les supprimer si Audrey ne peut pas les
confirmer ville par ville.

---

## 5. Portraits et photos mensongers

| Fichier | Utilisation dans le prototype | Problème | Action |
|---|---|---|---|
| `assets/photos/portrait-stock-a-propos.jpg` | Page « À propos », présenté comme le portrait d'Audrey | Photo de stock, pas Audrey | Remplacer par le vrai portrait HD d'Audrey (PROJECT_INPUTS.md §7, question ouverte #7) dès réception ; `alt` actuel à vérifier/neutraliser en attendant |
| `assets/photos/portrait-stock-01.jpg` | Bloc réassurance / avis | Photo de stock présentée en contexte humain | `alt` neutre, ne jamais nommer une personne |
| `assets/photos/portrait-stock-contact.jpg` | Page Contact | Photo de stock, contexte "interlocutrice" | `alt` neutre |
| `assets/photos/intervenante-stock-bureaux.jpg` | Prestation Bureaux, illustration d'un intervenant | Photo de stock présentée comme une intervenante Top-Famille Pro | `alt` du type « Nettoyage de bureaux (illustration) », jamais « une intervenante Top-Famille Pro » |
| `assets/photos/intervenante-stock-materiel.jpg` | Illustration matériel/produits | Photo de stock | `alt` neutre |
| `assets/photos/avatar-avis-demo.jpg` | Avatar des 40 avis démo | Associé à des faux noms | Supprimé avec les avis (section 2) |

Toutes les autres photos (`unsplash-*.jpg`, `hero-*.jpg`, `prestation-*.jpg`,
`locaux-professionnels-region.jpg`) sont des photos de lieux/objets (bureaux, vitres, locaux) sans
personne identifiable : pas de risque de portrait mensonger, mais elles restent des photos de
stock génériques — `alt` descriptif du contenu visuel réel, jamais un lieu ou une ville que la
photo ne montre pas réellement (CLAUDE.md §5.6).

**Aucune photo réelle d'intervenant n'existe** (PROJECT_INPUTS.md §7) : tant qu'aucune n'est
fournie, les visuels de stock restent la seule option, à condition que l'`alt` ne prétende jamais
représenter une personne réelle de l'entreprise.

---

## 6. Résumé — checklist de neutralisation

- [ ] Masquer note (5,0) + compteur (47 avis) + lien `#` tant que les vraies valeurs ne sont pas fournies
- [ ] Supprimer les 40 avis de démonstration (`demo: true`), toutes pages confondues
- [ ] Réintégrer uniquement les 6 avis authentiques listés dans CLAUDE.md §5.5
- [ ] Neutraliser ou reformuler les 18 scénarios locaux « exemple de besoin » pour rester dans le conditionnel générique, sans fréquence chiffrée non confirmée
- [ ] Remplacer `portrait-stock-a-propos.jpg` par le vrai portrait d'Audrey dès réception
- [ ] Revoir tous les `alt` des photos de stock pour qu'aucun ne prétende représenter une personne réelle de l'entreprise
- [ ] Vérifier qu'aucun concurrent cité en veille marché (PROJECT_INPUTS.md §10) n'apparaît sur une page publique
