# Audit SEO / GEO — 18 novembre 2026 (thème 0.18.0)

Outil : `node tools/audit-seo.mjs [url]`. Il lit le sitemap, ouvre chacune des 53 pages dans Chromium
et contrôle les balises, les titres, les données structurées, les images et le maillage. Lancé sur
le banc local en environnement `production`.

## 1. Déjà en place avant cette passe

Sur les 53 pages, aucun défaut n'a été trouvé sur les points suivants :

| Point | Constat |
|---|---|
| `title` | unique sur chaque page |
| Meta description | présente et unique sur chaque page |
| Canonical | absolue et auto-référente |
| `robots` | `index,follow` sur les 53 pages |
| `h1` | un seul par page, unique d'une page à l'autre |
| Hiérarchie des titres | des `h2`, aucun niveau sauté |
| Partage | Open Graph complet (image 1200×630) et Twitter Card |
| Fil d'Ariane | visible, avec `BreadcrumbList` |
| Données structurées | `ProfessionalService` (adresse réelle, 8 départements, téléphone, e-mail, `sameAs`, `priceRange`), `WebSite`, `WebPage`, `Service` (6 prestations), `Article` (3 conseils) |
| `FAQPage` | sur 41 pages, toujours identique à la FAQ affichée |
| Avis | aucun `Review` ni `AggregateRating`, conformément à CLAUDE.md §5.5 |
| Images | dimensions déclarées partout, aucun `alt` absent, aucun `alt` mensonger |
| Maillage | prestations ↔ zones ↔ articles, sans page orpheline |
| Robots et sitemap | sitemap de 53 adresses, `robots.txt` qui l'annonce et ne bloque aucun robot d'IA |

L'audit initial relevait 90 points. 66 étaient des `alt=""` décoratifs légitimes, mais 6 grands
visuels de cartes n'avaient pas d'`alt` : ils sont corrigés.

## 2. Corrigé dans cette passe

**Descriptions et titres.**
- 10 meta descriptions hors de la plage 110–165 caractères ont été ramenées dans la plage :
  Prestations (168), Tarifs (199), Cabinets (162), Saint-Apollinaire (170), Fontaine-lès-Dijon et
  Marsannay (167/166), mentions légales, confidentialité, cookies, Nevers, Mâcon.
- Le title de « Conseils » passe de 67 à 55 caractères.
- Titres de départements : « Nettoyage professionnel en Doubs / Jura / Nièvre / Yonne » était
  grammaticalement faux. Ils deviennent « Entreprise de nettoyage dans le Doubs », « dans le Jura »,
  « dans la Nièvre », « dans l'Yonne », et suivent la même formule pour les 8 départements et les
  8 communes.
- Les descriptions des 8 communes ne différaient que par le nom. Elles portent désormais le code
  postal et le tarif : « Entreprise de nettoyage à Talant (21240) : … 26 € HT/h, devis gratuit sous
  24 h. ».
- H1 de « À propos » : « Une entreprise régionale, un visage » annonçait un portrait qui n'existe
  plus. Il devient « Une entreprise de nettoyage régionale, une interlocutrice », qui porte le
  métier.

**Images.**
- Les 6 visuels de l'index des prestations reçoivent leur `alt` honnête, par exemple « Plateau de
  bureaux en open-space (photo d'illustration) ».
- Les logos, avatars et miniatures de 56 px restent décoratifs (`alt=""`), comme le veut
  l'accessibilité.

**Données structurées.**
- **`Service` sur les 26 pages de zone.**
  - `areaServed` désigne la ville ou le département de la page.
  - Le prestataire reste l'organisation unique : aucun `LocalBusiness` local (CLAUDE.md §5.2).
- **Tarif structuré.** `Offer` + `UnitPriceSpecification` : 26,00 EUR, unité « heure », HT. Il
  figure sur l'organisation, les 6 prestations et les 26 zones, avec le même prix partout
  (CLAUDE.md §5.3).
- **Organisation.** Ajout de `contactPoint` (le seul téléphone et le seul e-mail) et de
  `knowsAbout` (les métiers exercés).
- **Types de page précis.**
  - `ContactPage` : Contact.
  - `AboutPage` : À propos.
  - `CollectionPage` : Prestations, Zones, Conseils et Plan du site.
- **`FAQPage` automatique sur les pages statiques** qui affichent des questions-réponses. Il est
  construit à partir des mêmes blocs que l'affichage, et ne s'ajoute jamais en double. « Pourquoi
  nous » en reçoit un, pour ses 4 objections.

**GEO : visibilité dans les assistants IA.**
- **`/llms.txt`** suit le format llmstxt.org. Il présente l'entreprise, l'établissement unique, le
  tarif et ses conditions, le matériel fourni par le client, les exclusions, puis les 6
  prestations, les zones, les pages utiles et les 3 conseils.
  - Il est construit à chaque requête depuis les données du site : il ne peut pas les contredire.
  - Il ne contient ni note, ni avis, ni horaires non confirmés.
- Le script de mise en ligne vérifie sa présence (14ᵉ contrôle).

## 3. Volontairement laissé tel quel

| Signal | Pourquoi |
|---|---|
| Contenu court : Contact (154 mots), Recrutement, Conseils, cookies, confidentialité | Pages utilitaires : les allonger n'apporterait rien au référencement et nuirait à leur usage |
| Peu de liens sortants sur les pages légales et Recrutement | Normal pour ces pages, qui restent liées depuis le pied de page des 53 pages |
| Plan du site lié seulement depuis le pied de page | Usage normal d'un plan du site |
| Pas d'`openingHoursSpecification` | Horaires jamais confirmés par Audrey |
| Pas de `Review` / `AggregateRating` | Interdit (CLAUDE.md §5.5) |

## 4. Ce qui ne peut se faire qu'après la mise en ligne

- **Google Search Console** : déclarer le sitemap, puis suivre l'indexation et les requêtes réelles.
  Les mots-clés ne pourront être affinés qu'à partir de ces requêtes.
- **Fiche Google Business Profile** : c'est le premier levier du référencement local (pack
  « nettoyage bureaux Dijon »). Il faut la créer ou la revendiquer à l'adresse de
  Saint-Apollinaire, puis ajouter son URL dans Réglages → Réassurance & avis : la note s'affichera
  alors d'elle-même.
- **Avis réels** : c'est le signal qui manque le plus, sur le site comme sur la fiche Google.
- **Validation des données structurées** sur l'URL réelle avec l'outil de test des résultats
  enrichis de Google.
- **Lighthouse** sur Hostinger, avec LiteSpeed actif.

## 5. Vérifications

- Audit : **12 signaux restants**, tous listés au §3. Ni défaut de balise, ni défaut de schéma,
  ni défaut d'image.
- Suite Playwright complète : 1 389 tests réussis sur 1 390. L'unique échec, la parité dépôt ↔
  paquets, est survenu avant la reconstruction des paquets. Le test de parité a ensuite été
  rejoué : 4/4.
- Export : 53/53 routes. Parité : 1 287 fichiers. Recette du devis : 0 échec.
- Script de mise en ligne avec les paquets 0.18.0 sur le banc : 16/16 étapes, 14/14 contrôles.
