# Images — maquette Claude Design ↔ WordPress

> Fichier **généré** par `node tools/image-map.mjs`. Ne pas éditer à la main.
>
> Croise trois sources : l’extraction de la maquette, le manifeste du pipeline d’images du
> thème, et les fichiers réellement servis par WordPress page par page.

## 1. Visuels de la maquette et leur équivalent WordPress

| Rôle | `alt` de la maquette | Dimensions natives | Affiché | Routes | Slot WordPress |
|---|---|---|---|---|---|
| en-tete | Top-Famille Pro | 759x402 | 155×82 | 53 | — |
| hero | Bureaux professionnels lumineux entretenus par Top-Famille Pro en Bourgogne-Franche-Comté | 1100x733 | 512×448 | 1 | `hero-main` |
| hero | Intervenante Top-Famille Pro nettoyant une vitre | 560x373 | 215×215 | 1 | — |
| corps | Nettoyage de bureaux et open-spaces | 900x600 | 580×278 | 1 | `service-bureaux` |
| corps | Nettoyage de commerces et boutiques | 900x601 | 580×278 | 1 | `service-commerces` |
| corps | _(vide — visuel décoratif)_ | 120x180 | 44×44 | 1 | — |
| corps | Audrey, votre interlocutrice Top-Famille Pro | 800x1007 | 420×525 | 1 | — |
| corps | À quelle fréquence faire nettoyer ses bureaux ? | 900x601 | 381×214 | 3 | — |
| corps | Combien coûte le nettoyage de bureaux ? | 900x601 | 381×214 | 3 | `service-bureaux` |
| corps | Comment rédiger un cahier des charges de nettoyage ? | 900x600 | 381×214 | 3 | — |
| pied-de-page | Top-Famille Pro | 1024x1009 | 60×60 | 53 | — |
| hero | Audrey, Top-Famille Pro | 200x252 | 60×60 | 2 | — |
| corps | Nettoyage de bureaux | 800x534 | 381×238 | 1 | `service-bureaux` |
| corps | Nettoyage de commerces | 800x534 | 381×238 | 1 | `service-commerces` |
| corps | Cabinets & professions libérales | 800x534 | 381×238 | 1 | — |
| corps | Copropriétés & parties communes | 800x533 | 381×238 | 1 | — |
| corps | Locations meublées & hébergements | 800x533 | 381×238 | 1 | — |
| corps | Nettoyage ponctuel & remise en état | 800x533 | 381×238 | 1 | — |
| hero | Intervenant Top-Famille Pro entretenant des bureaux professionnels | 1000x667 | 512×384 | 1 | — |
| corps | _(vide — visuel décoratif)_ | 800x534 | 56×56 | 3 | — |
| corps | _(vide — visuel décoratif)_ | 800x533 | 56×56 | 3 | — |
| corps | Audrey, interlocutrice dédiée Top-Famille Pro | 800x1007 | 504×504 | 1 | — |
| hero | Nettoyage de bureaux en Bourgogne-Franche-Comté | 800x534 | 522×392 | 1 | `service-bureaux` |
| hero | Nettoyage de commerces et de surfaces de vente | 800x534 | 522×392 | 1 | `service-commerces` |
| hero | Nettoyage de cabinets et de professions libérales | 800x534 | 522×392 | 1 | — |
| hero | Entretien de copropriétés et de parties communes | 800x533 | 522×392 | 1 | — |
| hero | Nettoyage de locations meublées et d'hébergements | 800x533 | 522×392 | 1 | — |
| hero | Nettoyage ponctuel et remise en état | 800x533 | 522×392 | 1 | — |
| hero | Locaux professionnels en Bourgogne-Franche-Comté | 1000x667 | 512×384 | 1 | — |
| hero | Locaux professionnels à Dijon | 900x601 | 512×384 | 1 | — |
| hero | Locaux professionnels à Beaune | 900x601 | 512×384 | 1 | — |
| hero | Locaux professionnels à Besançon | 900x600 | 512×384 | 1 | — |
| hero | Locaux professionnels à Dole | 900x601 | 512×384 | 1 | — |
| hero | Locaux professionnels à Lons-le-Saunier | 900x600 | 512×384 | 1 | — |
| hero | Locaux professionnels à Nevers | 900x600 | 512×384 | 1 | — |
| hero | Locaux professionnels à Vesoul | 900x675 | 512×384 | 1 | — |
| hero | Locaux professionnels à Chalon-sur-Saône | 900x600 | 512×384 | 1 | — |
| hero | Locaux professionnels à Mâcon | 900x601 | 512×384 | 1 | — |
| hero | Locaux professionnels à Auxerre | 900x600 | 512×384 | 1 | — |
| hero | Locaux professionnels à Belfort | 900x601 | 512×384 | 1 | — |
| hero | Audrey, Top-Famille Pro | 800x1198 | 400×500 | 1 | — |
| hero | Intervenant Top-Famille Pro préparant son matériel de nettoyage | 1000x667 | 512×384 | 1 | — |
| hero | Locaux professionnels à Saint-Apollinaire | 900x601 | 512×384 | 1 | — |
| hero | Locaux professionnels à Chenôve | 900x600 | 512×384 | 1 | — |
| hero | Locaux professionnels à Quetigny | 900x601 | 512×384 | 1 | — |
| hero | Locaux professionnels à Talant | 900x600 | 512×384 | 1 | — |
| hero | Locaux professionnels à Longvic | 900x600 | 512×384 | 1 | — |
| hero | Locaux professionnels à Fontaine-lès-Dijon | 900x600 | 512×384 | 1 | — |
| hero | Locaux professionnels à Marsannay-la-Côte | 900x600 | 512×384 | 1 | — |

## 2. Slots du pipeline d’images du thème

| Slot | Dimensions natives | Largeurs générées | Formats | AVIF (max) | WebP (max) | JPEG (max) | `alt` par défaut |
|---|---|---|---|---|---|---|---|
| `hero-main` | 1200×800 | 480 / 760 / 1040 / 1200 | AVIF, WebP, JPEG | 34 Ko | 38 Ko | 73 Ko | Espace de bureaux professionnels, lumineux et rangé (photo d’illustration) |
| `hero-secondary` | 460×306 | 220 / 340 / 460 | AVIF, WebP, JPEG | 6 Ko | 7 Ko | 12 Ko | Nettoyage de vitres avec équipement de protection (photo d’illustration) |
| `service-bureaux` | 640×427 | 320 / 480 / 640 | AVIF, WebP, JPEG | 25 Ko | 34 Ko | 46 Ko | Nettoyage de bureaux et open-spaces (photo d’illustration) |
| `service-commerces` | 640×427 | 320 / 480 / 640 | AVIF, WebP, JPEG | 22 Ko | 29 Ko | 42 Ko | Nettoyage de commerces et de surfaces de vente (photo d’illustration) |
| `article-1` | 640×427 | 320 / 480 / 640 | AVIF, WebP, JPEG | 11 Ko | 14 Ko | 24 Ko | Couloir de bureaux et kitchenette (photo d’illustration) |
| `article-2` | 640×427 | 320 / 480 / 640 | AVIF, WebP, JPEG | 12 Ko | 16 Ko | 24 Ko | Poste de travail avec ordinateur (photo d’illustration) |
| `article-3` | 640×427 | 320 / 480 / 640 | AVIF, WebP, JPEG | 12 Ko | 16 Ko | 24 Ko | Bureau avec documents et ordinateur (photo d’illustration) |
| `service-generic` | 960×640 | 480 / 760 / 960 | AVIF, WebP, JPEG | 16 Ko | 19 Ko | 37 Ko | Intervention de nettoyage professionnel avec équipement de protection (photo d’illustration) |
| `audrey-placeholder` | 640×958 | 320 / 480 / 640 | AVIF, WebP, JPEG | 22 Ko | 26 Ko | 47 Ko | Photo d’illustration temporaire — portrait définitif à venir |

## 3. Fichiers réellement servis par WordPress

| Fichier servi | Natif | Affiché | Chargement | Priorité | Routes | Cassée |
|---|---|---|---|---|---|---|
| `logo-horizontal.png` | 320x169 | 155×82 | eager | — | 159 | non |
| `article-3-640.avif` | 559x373 | 512×448 | eager | high | 20 | non |
| `service-generic-760.avif` | 600x400 | 512×448 | eager | high | 4 | non |
| `service-bureaux-640.avif` | 648x432 | 580×278 | lazy | — | 2 | non |
| `service-commerces-640.avif` | 648x432 | 580×278 | lazy | — | 2 | non |
| `audrey-placeholder-640.jpg` | 640x958 | 420×525 | lazy | — | 2 | non |
| `article-2-480.avif` | 400x266 | 381×214 | lazy | — | 2 | non |
| `article-1-640.avif` | 590x393 | 707×472 | eager | high | 2 | non |
| `hero-main-760.avif` | 600x399 | 512×448 | eager | high | 1 | non |
| `hero-secondary-220.avif` | 220x147 | 215×215 | lazy | — | 1 | non |
| `article-1-480.avif` | 400x267 | 381×214 | lazy | — | 1 | non |
| `article-3-480.avif` | 400x266 | 381×214 | lazy | — | 1 | non |
| `article-2-640.avif` | 820x547 | 820×461 | eager | high | 1 | non |

## 4. Contrôles

- Images cassées côté WordPress : **0**
- Images sans `alt` : **0** (aucune) — un `alt` vide est correct pour un visuel purement décoratif dont le sens est déjà porté par le texte voisin ; il est fautif partout ailleurs.
- Images en `fetchpriority="high"` : **5** — une seule par page, celle du LCP (CLAUDE.md §8).

## 5. Ce que ces visuels ne prétendent pas être

Aucun visuel du site ne représente une personne, un client ou un local réels. Ce sont des
images d’illustration, reprises de la maquette, et leurs `alt` le disent. Le portrait
associé à Audrey est explicitement provisoire et remplaçable depuis
Apparence → Personnaliser → Équipe (CLAUDE.md §5.6).
