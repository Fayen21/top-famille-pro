# Diagnostic LCP — route par route

> Fichier **généré** par `node tools/diagnostic-lcp.mjs`, depuis les rapports Lighthouse

> conservés dans `export/lighthouse`. Ne pas éditer à la main.

Un LCP se décompose en quatre temps, et chacun appelle une correction différente :
**TTFB** (le serveur répond), **découverte** (le navigateur apprend qu'il faut charger la
ressource), **transfert** (elle arrive), **rendu** (la page peut enfin peindre). Compresser
une image découverte 900 ms trop tard ne gagne rien : c'est pourquoi les quatre sont
relevés séparément.

> **Les quatre temps ne s'additionnent pas jusqu'au LCP, et c'est normal.** La colonne
> « LCP » est la valeur **simulée** par Lighthouse — le lien mobile bridé qu'il modélise —
> tandis que la décomposition est **observée** sur la machine de mesure, qui est rapide. Les
> quatre temps disent donc où le navigateur passe son temps, pas combien il en passera sur un
> téléphone. Les additionner et conclure que le compte n'y est pas serait lire le tableau à
> l'envers.

Quand la décomposition observée est quasi nulle et que le LCP simulé reste haut, la cause
n'est ni la ressource ni le rendu : c'est la **chaîne critique** — le nombre d'allers-retours
réseau à franchir avant le premier rendu.

**14 mesures · 4 au-dessus de 2.5 s.**

| Mesure | LCP | Élément LCP | TTFB | Découverte | Transfert | Rendu | Ressource | Taille | Priorité | Polices | CSS |
|---|---:|---|---:|---:|---:|---:|---|---:|---|---|---|
| `accueil-bureau` | 0.60 s | `div.tfp-hero__media > div.tfp-hero__media-main` | 50 ms | 9 ms | 29 ms | 149 ms | hero-main-760.avif | 20 ko | High | 7 · 259 ko · fin 201 ms | 2 · 14 ko · fin 87 ms |
| `accueil-mobile` | **2.87 s** | `main#tfp-main > section.tfp-hero > div.tfp-her` | 49 ms | — | — | 165 ms | — (texte) | — | — | 7 · 259 ko · fin 203 ms | 2 · 14 ko · fin 87 ms |
| `conseils-cout-nettoyage-bureaux-bureau` | 0.56 s | `header.tfp-container > div.tfp-article__cover ` | 58 ms | 11 ms | 40 ms | 121 ms | article-2-640.avif | 15 ko | High | 6 · 218 ko · fin 197 ms | 2 · 14 ko · fin 100 ms |
| `conseils-cout-nettoyage-bureaux-mobile` | 2.42 s | `header.tfp-container > div.tfp-article__cover ` | 55 ms | 14 ms | 27 ms | 97 ms | article-2-640.avif | 15 ko | High | 5 · 184 ko · fin 175 ms | 2 · 14 ko · fin 95 ms |
| `contact-bureau` | 0.53 s | `div > main#tfp-main > section.tfp-container > ` | 48 ms | — | — | 165 ms | — (texte) | — | — | 6 · 218 ko · fin 168 ms | 2 · 14 ko · fin 74 ms |
| `contact-mobile` | 2.34 s | `div > main#tfp-main > section.tfp-container > ` | 47 ms | — | — | 122 ms | — (texte) | — | — | 5 · 184 ko · fin 149 ms | 2 · 14 ko · fin 79 ms |
| `demande-de-devis-bureau` | 0.54 s | `section.tfp-quote-page > div.tfp-container > d` | 68 ms | — | — | 164 ms | — (texte) | — | — | 6 · 218 ko · fin 189 ms | 2 · 14 ko · fin 94 ms |
| `demande-de-devis-mobile` | 2.49 s | `section.tfp-quote-page > div.tfp-container > d` | 46 ms | — | — | 142 ms | — (texte) | — | — | 6 · 218 ko · fin 168 ms | 2 · 14 ko · fin 80 ms |
| `prestations-bureaux-bureau` | 0.62 s | `div.tfp-hero__media > div.tfp-hero__media-main` | 53 ms | 9 ms | 22 ms | 141 ms | service-bureaux-640.avif | 25 ko | High | 7 · 259 ko · fin 179 ms | 2 · 14 ko · fin 81 ms |
| `prestations-bureaux-mobile` | **2.86 s** | `main#tfp-main > section.tfp-hero > div.tfp-her` | 54 ms | — | — | 142 ms | — (texte) | — | — | 7 · 259 ko · fin 190 ms | 2 · 14 ko · fin 87 ms |
| `tarifs-bureau` | 0.58 s | `div > main#tfp-main > section.tfp-container > ` | 51 ms | — | — | 152 ms | — (texte) | — | — | 7 · 259 ko · fin 177 ms | 2 · 14 ko · fin 77 ms |
| `tarifs-mobile` | **2.71 s** | `div > main#tfp-main > section.tfp-container > ` | 46 ms | — | — | 131 ms | — (texte) | — | — | 7 · 259 ko · fin 164 ms | 2 · 14 ko · fin 77 ms |
| `zones-intervention-cote-dor-dijon-bureau` | 0.58 s | `div.tfp-hero__media > div.tfp-hero__media-main` | 56 ms | 11 ms | 23 ms | 152 ms | ville-dijon-760.avif | 17 ko | High | 7 · 259 ko · fin 187 ms | 2 · 14 ko · fin 89 ms |
| `zones-intervention-cote-dor-dijon-mobile` | **2.86 s** | `div.tfp-hero__media > div.tfp-hero__media-main` | 58 ms | 15 ms | 26 ms | 114 ms | ville-dijon-760.avif | 17 ko | High | 7 · 259 ko · fin 199 ms | 2 · 14 ko · fin 96 ms |

## Mesures au-dessus de la cible

- `accueil-mobile` — 2.87 s, dominé par **rendu** (165 ms).
- `prestations-bureaux-mobile` — 2.86 s, dominé par **rendu** (142 ms).
- `tarifs-mobile` — 2.71 s, dominé par **rendu** (131 ms).
- `zones-intervention-cote-dor-dijon-mobile` — 2.86 s, dominé par **rendu** (114 ms).


## Ce que la mesure dit, et ce qu'elle ne dit pas

### Les quatre mesures au-dessus de la cible sont toutes en profil MOBILE

Les sept mesures de profil bureau sont sous la cible. Les quatre dépassements sont
`accueil`, `prestations/bureaux`, `tarifs` et `zones-intervention/cote-dor/dijon`, en mobile,
entre 2,71 s et 2,87 s — donc entre 8 % et 15 % au-dessus de 2,5 s.

### Sur trois des quatre, l'élément LCP est du TEXTE

| Mesure | Élément LCP | Nature |
|---|---|---|
| `accueil-mobile` | `p.tfp-hero__lede` | texte |
| `prestations-bureaux-mobile` | `p.tfp-hero__lede` | texte |
| `tarifs-mobile` | `p.tfp-section__lede` | texte |
| `dijon-mobile` | visuel du hero (`ville-dijon-760.avif`, 17 ko, priorité **High**) | image |

Un LCP **texte** ne s'améliore ni en compressant une image ni en préchargeant une ressource : il
est peint dès que le HTML et la CSS sont là. Sur la seule mesure où l'élément est une image, la
ressource pèse **17 ko**, arrive en priorité **High**, et sa découverte (15 ms) comme son transfert
(26 ms) sont négligeables. **Il n'y a donc pas de ressource à optimiser.**

### La décomposition observée est quasi nulle

Sur les quatre, la somme des temps observés — TTFB, découverte, transfert, rendu — tient entre
190 et 250 ms. Le reste du LCP simulé vient du **modèle de lien mobile** de Lighthouse, qui
facture chaque aller-retour réseau de la chaîne critique.

### La chaîne critique, mesurée

| Élément | Nombre | Poids transféré | Fin de chargement observée |
|---|---:|---:|---:|
| Feuilles de style **bloquantes** | 2 | ~14 ko | 77 à 96 ms |
| Polices préchargées | 4 (sur 7 servies) | 259 ko au total | 164 à 203 ms |

Deux feuilles bloquantes : celle du thème enfant, et `generatepress/style.css` du thème parent.
Chacune coûte un aller-retour avant le premier rendu.

## Les leviers, et pourquoi ils ne se valent pas

| Levier | Effet attendu | Risque | Décision |
|---|---|---|---|
| **CSS critique en ligne** (`CLAUDE.md` §8) | Supprime l'aller-retour qui précède le premier rendu — le terme dominant d'un LCP texte | FOUC et CLS si l'extrait est incomplet ; la marge de CLS est de 0,010 | **Levier principal. Non appliqué dans cette passe.** |
| **Retirer la feuille du thème parent** | Un aller-retour de moins | **Non vérifiable sur ce banc** : la feuille de GeneratePress y est un fichier de 47 octets, alors qu'en production elle porte les styles de base du thème parent. Mesurer ici un gain qui n'existerait pas en production serait se mentir | **Écarté faute de pouvoir le mesurer honnêtement.** |
| **Réduire les 4 préchargements de polices** | Moins de concurrence de bande passante au moment critique | **À ne pas faire.** Ces quatre préchargements ont été ajoutés en G24 pour corriger un CLS mesuré à **0,25** : sans eux, l'en-tête passe de 48 à 73 px au remplacement de police et toute la page remonte de 25 px. Gagner sur le LCP en reperdant 25 fois la cible de CLS n'est pas une optimisation | **Écarté, avec sa raison.** |
| Compresser l'image LCP | Nul | — | Sans objet : 17 ko, priorité High, transfert de 26 ms |

## État

**Critère non atteint** : le LCP mobile médian reste au-dessus de 2,5 s sur quatre des sept routes.
Le diagnostic est complet et la cause identifiée — la chaîne critique, pas les ressources — mais la
correction principale, le CSS critique, n'est pas appliquée dans cette passe.
