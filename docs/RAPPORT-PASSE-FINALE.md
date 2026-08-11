# Rapport de la passe finale — fidélité Claude Design

> Branche `hotfix-production-fidelite-claude-design`, PR #9. Rien n'a été fusionné, rien n'a été
> déployé, aucune donnée de production n'a été touchée.

---

## 1. Verdict

**PARTIEL — ÉCARTS RESTANTS.**

Quatre écarts subsistent, tous mesurés et nommés (§18). Aucun n'est un contenu fictif, un avis
inventé, un tarif différencié ni une donnée d'immatriculation non confirmée : ce sont des écarts
de mise en page et de mesure, dont trois restent à instruire.

---

## 2. Page Contact — reproduite

Les sept cartes de la maquette sont rendues : deux cartes d'orientation (403 × 104, fond #EFEFEF,
rayon 16, deux colonnes, écart 14), quatre cartes de coordonnées (512 × 86, blanches, rayon 12,
écart 12) et la carte marine de rappel (fond #174A81, rayon 14).

Le **formulaire de contact court** manquait : il existe désormais, et il est distinct du formulaire
de devis en deux étapes, qui n'a pas été touché. La maquette distingue deux intentions — « J'ai une
question » et « J'ai un besoin de nettoyage » — et renvoyer la première vers le second parcours
faisait abandonner les visiteurs qui n'ont qu'une question.

Champs, dans l'ordre relevé : Nom · Entreprise (facultatif) · E-mail · Téléphone (facultatif) ·
Objet (cinq valeurs) · Message · consentement. Obligatoires : nom, e-mail, objet, message,
consentement — jamais entreprise ni téléphone.

Un défaut a été trouvé au passage : la carte de note Google lisait une clé inexistante et affichait
« /5 sur Google » sans chiffre devant.

## 3. Sécurité du formulaire

Nonce vérifié en premier · honeypot hors écran et hors parcours clavier, répondant « envoyé » à un
automate pour ne pas lui apprendre qu'il a été repéré · limitation à cinq envois par heure et par
adresse · validation **serveur** complète, la validation client n'étant qu'un confort · valeurs
conservées en cas d'erreur, parce que perdre un message rédigé fait perdre le contact · confirmation
affichée seulement après retour serveur.

**Aucun test ne peut faire partir un e-mail.** Le thème n'appelle `wp_mail()` qu'en environnement
autre que `local` ou `development`, et le formulaire porte alors l'attribut `data-tfp-mail-disabled`.
La suite lit cet attribut **avant** toute soumission et se saute d'elle-même s'il est absent.

## 4. Horaires provisoires

La maquette écrit « Du lundi au vendredi · à confirmer · réponse sous 24 h » : l'amplitude n'a jamais
été arrêtée. Elle est reprise, mais présentée pour ce qu'elle est — une indication provisoire, avec
une mention visible dans la carte — et elle est administrable dans Réglages → Réassurance & avis.

**Aucun `openingHoursSpecification` n'est émis nulle part.** Une amplitude non confirmée déclarée en
donnée structurée est un engagement d'ouverture opposable, pas une illustration.

## 5. Tests Contact — 20, tous verts

Sept cartes et leur ordre · formulaire présent et distinct du devis · ordre des champs · libellés
exacts · champs obligatoires · erreurs annoncées (`role="alert"`, `aria-invalid`, `aria-describedby`)
· nonce · honeypot réellement hors écran et hors du parcours clavier · consentement · prévention du
double envoi · navigation clavier complète · six largeurs · absence d'horaires structurés.

## 6. Article sur le coût

Le tableau de budgets est présent et exact : trois lignes, quatre en-têtes, montants recalculés par
le test (`mensuel = heures × 27 + 9`, `premier mois = + 50`).

## 7. Données structurées `Article`

Vérifiées sur les trois articles : auteur `Person` — jamais `admin` — nom visible sur la page, dates
correspondant aux dates françaises affichées, `headline` égal au H1, canonical auto-référente, image
de l'article et non le logo du site (elle renvoie bien 200), aucun schéma d'avis. Trois tests.

## 8. SEO complémentaire

`title` et canonical uniques sur les 53 routes. Aucune fuite de `localhost` dans l'export. Sitemap
et robots.txt cohérents. Les huit communes non validées restent en `noindex,follow`.

## 9. Politique de confidentialité

La formule « durées exactes à confirmer avant publication » a été remplacée : un marqueur de travail
n'a rien à faire sur une page publique, et une page de confidentialité qui annonce qu'elle n'est pas
finie ne vaut rien juridiquement.

## 10. URL parasites — contrôle outillé

Les trois URL — `/page-perso-de-ladministrateur/`, `/nettoyage-ecologique-ancienne-offre/`,
`/devis-rapide/` — étaient **publiées et référencées au sitemap** sur le banc de production, alors
qu'aucun script de contenu ne les crée.

`bin/verifier-installation.php` compare ce que l'installation publie aux 52 contenus des 53 routes,
signale ceux qui figurent au sitemap, et vérifie en retour qu'aucune route attendue ne manque. Il
retrouve les trois. Il ne supprime rien : une page inattendue peut avoir été ajoutée volontairement.
L'étape 20 du guide de déploiement rend ce contrôle obligatoire avant l'ouverture de l'indexation.

Les trois pages ont été supprimées du banc ; l'installation ne publie plus que les 53 routes.

## 11. Pages de zone — quatre défauts structurels corrigés

1. **Le niveau des titres était perdu à l'extraction.** « Communes secondaires documentées » est un
   `h3` sous « Nos villes d'intervention », pas un `h2` de plus. Le niveau perdu, la bande passait
   de deux colonnes de 566 px à quatre de 265 px, les pastilles de communes tombaient à une ou deux
   par ligne au lieu de quatre, et la hiérarchie des titres devenait fausse.
2. **La bande tarifaire est à trois colonnes**, pas à deux : texte 394, exemple 344, témoignage 374,
   écart 34, mesurés à 1440 px. Les deux cartes blanches étaient empilées et deux fois plus étroites.
3. **La phrase qui justifie le montant appartient à la carte d'exemple**, pas à la colonne de texte,
   où elle expliquait un chiffre affiché à 400 px de là.
4. **Les trois garanties du bandeau tarifaire étaient perdues sur les 26 pages.** L'extraction ne
   relevait que les feuilles, et le libellé (« Devis gratuit sous 24 h ») est un nœud texte à côté de
   l'icône. Le conteneur se rendait vide, haut de 0 px.

S'y ajoutent le panneau de maillage des six prestations (566 × 338, fond #DCE7EB, rangées blanches
séparées d'un filet d'un pixel) et la pastille marine du prix, rendus en texte nu jusqu'ici.

Côte-d'Or : 14 anomalies dont 4 graves → 3, aucune grave.

## 12. Inventaire des cartes — trois faux positifs d'outil corrigés

- Un **texte volontairement corrigé** produisait une carte absente ET une carte supplémentaire.
  « 5,0/5 Google » contre « 5,0/5 sur Google » suffisait : un mot d'écart, deux anomalies. Un
  appariement approché (moitié des mots en commun, bande voisine) les réconcilie, dans une famille
  `texte` listée à part.
- Le même appariement traverse les archétypes : une carte rendue en pastille d'un côté et en carte
  de l'autre est un **écart de forme**, pas une disparition doublée d'une apparition.
- Une carte sans texte, sans image et sans icône est un cadre décoratif : 21 coquilles vides étaient
  comptées.

Côté thème, la seule cause des ~110 rangées de pastilles coupées au mauvais endroit : `.tfp-chip`
appliquait `--fs-sm` (15 px) là où son propre commentaire annonçait les 14 px relevés. Chaque
pastille était 4 % trop large. Elles mesurent maintenant 79 × 41 px, comme le prototype.

**934 anomalies dont 283 graves → 542 dont 101.**

## 13. Classement exhaustif de `surplus` et `colonnes`

`docs/ANOMALIES-SURPLUS-COLONNES.md` rattache **chacune des 209 occurrences** — route, largeur,
bande, archétype, contenu — à une cause nommée, avec son verdict, sa correction et son test. Aucune
n'est agrégée ni tronquée.

| Cause | Occurrences | Verdict |
|---|---:|---|
| Rangée de pastilles coupée à un rang près | 61 | Faux positif résiduel de l'outil |
| Badge Google composé de plusieurs éléments | 18 | Écart réel, mineur |
| Bouton d'appel à l'action contextuel | 1 | Écart voulu (CLAUDE.md §8) |
| Lien de ville rendu en carte | 34 | À instruire |
| Bloc de contenu d'une page ou d'un article | 28 | À instruire |
| Élément de liste rendu en micro-carte | 18 | À instruire |
| Rangée de pastilles à deux rangs ou plus | 15 | À instruire |
| Carte d'exemple tarifaire (prestations, tarifs) | 8 | À instruire |
| Autres écarts de colonnes | 8 | À instruire |
| Autres cartes supplémentaires | 18 | À instruire |

Les causes « à instruire » le sont réellement : affirmer une cause plausible sans l'avoir vérifiée
vaudrait moins que ne rien affirmer.

## 14. Fidélité aux six largeurs

53 routes comparées à 320, 375, 768, 1024, 1440 et 1920 px, bande par bande, sans aucun
`min-height`, marge compensatoire ni bloc invisible.

| Largeur | Routes dans 95–105 % |
|---|---|
| 375 px | 23 / 53 |
| 768 px | 7 / 53 |
| 1024 px | 43 / 53 |
| 1440 px | 40 / 53 |
| 1920 px | 40 / 53 |

**768 px est la largeur la moins fidèle**, et la cause est identifiée : la maquette conserve deux
colonnes tant que la place le permet — sa liste de tâches est encore sur deux colonnes dans 707 px —
là où les composants du thème s'empilent dès 819 px. La liste de tâches a été alignée sur la
maquette (`minmax(min(100%, 320px), 1fr)`, écart 10 : deux colonnes à 654 et 707 px, une seule à
339 px). Les autres points de rupture n'ont pas été abaissés : c'est un changement global qu'il faut
re-vérifier sur les 53 routes et les six largeurs, ce que cette passe n'a pas fait.

## 15. Accessibilité

Critère 2.5.8 (AA — 24 × 24 px **ou** espacement **ou** exception en ligne, jamais les 44 px du
critère AAA 2.5.5) : aucune violation sur les 53 routes. Accessibilité Lighthouse : 100 sur les
sept pages, en mobile comme en bureau.

## 16. Performances

Mesurées sur `tools/banc-production.mjs`, qui place devant le rig la compression et les en-têtes de
cache d'un LiteSpeed Hostinger. Mesurer sur le serveur PHP nu donnerait des chiffres qui n'existent
sur aucun hébergement.

| Page | Perf. mobile | Perf. bureau | CLS mobile | CLS bureau |
|---|---:|---:|---:|---:|
| Accueil | 93 | 100 | 0,000 | 0,028 |
| Prestation | 94 | 100 | 0,000 | 0,029 |
| Ville | 92 | 100 | 0,000 | 0,028 |
| Tarifs | 97 | 100 | 0,000 | 0,028 |
| Article | 98 | 100 | 0,000 | 0,029 |
| Contact | 99 | 100 | 0,000 | 0,029 |
| Formulaire de devis | 96 | 100 | 0,000 | 0,029 |

Accessibilité, bonnes pratiques et SEO : **100 sur les quatorze mesures**.

Le décalage de mise en page venait de l'**en-tête**, pas du hero où Lighthouse le relevait : ses deux
boutons, en semi-gras, s'affichaient d'abord dans la police système — plus large — passaient sur deux
lignes, l'en-tête faisait 121 px au lieu de 48, et toute la page remontait de 25 px. Les deux fontes
du premier écran sont désormais préchargées et passées en `font-display: optional`. Page de ville en
profil bureau : **CLS 0,255 → 0,028**, performance mobile 92 → 99 sur Contact.

## 17. Exports et livrables

Reconstruits depuis une installation propre, après synchronisation du thème et rejeu de tous les
scripts de contenu :

```
Export : 53 routes · 0 statut non-200
Ressources locales manquantes : 0
Fichiers contenant « localhost » : 0
Images cassées (53 routes × 2 largeurs) : 0
Requêtes vers un domaine externe : 0
Routes ouvrables hors ligne sans image cassée : 53 / 53
```

## 18. Écarts restants — les quatre, nommés

1. **CLS de 0,028 en profil bureau, sur les sept pages.** Sous le seuil « bon » de Google (0,10),
   au-dessus de la cible interne de 0,010. Origine unique : l'en-tête se réagence encore de quelques
   pixels au chargement. Réduit d'un facteur neuf dans cette passe, pas annulé.
2. **Fidélité à 768 px : 7 routes sur 53 dans la tolérance.** Cause identifiée (§14), correction
   partielle appliquée, abaissement global des points de rupture non fait.
3. **Sept causes d'anomalies « à instruire »** sur les dix du classement (§13) — 129 occurrences.
4. **Badge Google composé de plusieurs éléments** : conforme à l'écran, compté comme une carte de
   plus par l'inventaire.

## 19. Non-régression

**965 tests Playwright, tous verts.** Aucune donnée fictive, aucun avis ni note inventés, aucun
`Review` ni `AggregateRating`, aucun tarif différencié par ville, aucune commune non validée en
`index`, aucun `alt` mensonger, aucune donnée d'immatriculation non confirmée.

Les témoignages provisoires portent tous `data-tfp-provisional` et une mention visible dans leur
composant, vérifiée en visibilité calculée sur les 53 routes.

## 20. Ce qui reste une décision humaine

Le nombre réel d'avis Google et l'URL de la fiche · la validation de la citation attribuée à Audrey
par l'intéressée · la validation, une par une, des huit communes secondaires · le remplacement des
témoignages provisoires par de vrais avis · les horaires de contact réels · le sort des contenus que
`bin/verifier-installation.php` signalera sur l'installation réelle.
