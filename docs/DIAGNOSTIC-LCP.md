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

**14 mesures · 0 au-dessus de 2.5 s.**

| Mesure | LCP | Élément LCP | TTFB | Découverte | Transfert | Rendu | Ressource | Taille | Priorité | Polices | CSS |
|---|---:|---|---:|---:|---:|---:|---|---:|---|---|---|
| `accueil-bureau` | 0.44 s | `div.tfp-hero__media > div.tfp-hero__media-main` | 48 ms | 10 ms | 23 ms | 142 ms | hero-main-760.avif | 20 ko | High | 2 · 75 ko · fin 81 ms | 2 · 14 ko · fin 79 ms |
| `accueil-mobile` | 1.82 s | `main#tfp-main > section.tfp-hero > div.tfp-her` | 48 ms | — | — | 149 ms | — (texte) | — | — | 2 · 75 ko · fin 82 ms | 2 · 14 ko · fin 83 ms |
| `conseils-cout-nettoyage-bureaux-bureau` | 0.42 s | `header.tfp-container > div.tfp-article__cover ` | 48 ms | 12 ms | 21 ms | 107 ms | article-2-640.avif | 15 ko | High | 2 · 75 ko · fin 79 ms | 2 · 14 ko · fin 81 ms |
| `conseils-cout-nettoyage-bureaux-mobile` | 1.82 s | `header.tfp-container > div.tfp-article__cover ` | 46 ms | 16 ms | 19 ms | 84 ms | article-2-640.avif | 15 ko | High | 2 · 75 ko · fin 80 ms | 2 · 14 ko · fin 80 ms |
| `contact-bureau` | 0.41 s | `div > main#tfp-main > section.tfp-container > ` | 49 ms | — | — | 164 ms | — (texte) | — | — | 2 · 75 ko · fin 83 ms | 2 · 14 ko · fin 85 ms |
| `contact-mobile` | 1.66 s | `div > main#tfp-main > section.tfp-container > ` | 46 ms | — | — | 119 ms | — (texte) | — | — | 2 · 75 ko · fin 74 ms | 2 · 14 ko · fin 76 ms |
| `demande-de-devis-bureau` | 0.39 s | `section.tfp-quote-page > div.tfp-container > d` | 54 ms | — | — | 148 ms | — (texte) | — | — | 2 · 75 ko · fin 81 ms | 2 · 14 ko · fin 85 ms |
| `demande-de-devis-mobile` | 1.67 s | `section.tfp-quote-page > div.tfp-container > d` | 48 ms | — | — | 141 ms | — (texte) | — | — | 2 · 75 ko · fin 80 ms | 2 · 14 ko · fin 81 ms |
| `prestations-bureaux-bureau` | 0.42 s | `div.tfp-hero__media > div.tfp-hero__media-main` | 50 ms | 10 ms | 21 ms | 134 ms | service-bureaux-640.avif | 25 ko | High | 2 · 75 ko · fin 79 ms | 2 · 14 ko · fin 80 ms |
| `prestations-bureaux-mobile` | 1.82 s | `div.tfp-hero__media > div.tfp-hero__media-main` | 88 ms | 14 ms | 20 ms | 102 ms | service-bureaux-640.avif | 25 ko | High | 2 · 75 ko · fin 120 ms | 2 · 14 ko · fin 120 ms |
| `tarifs-bureau` | 0.37 s | `div > main#tfp-main > section.tfp-container > ` | 41 ms | — | — | 147 ms | — (texte) | — | — | 2 · 75 ko · fin 64 ms | 2 · 14 ko · fin 64 ms |
| `tarifs-mobile` | 1.66 s | `div > main#tfp-main > section.tfp-container > ` | 49 ms | — | — | 137 ms | — (texte) | — | — | 2 · 75 ko · fin 84 ms | 2 · 14 ko · fin 85 ms |
| `zones-intervention-cote-dor-dijon-bureau` | 0.42 s | `div.tfp-hero__media > div.tfp-hero__media-main` | 54 ms | 10 ms | 20 ms | 129 ms | ville-dijon-760.avif | 17 ko | High | 2 · 75 ko · fin 81 ms | 2 · 14 ko · fin 82 ms |
| `zones-intervention-cote-dor-dijon-mobile` | 1.82 s | `div.tfp-hero__media > div.tfp-hero__media-main` | 54 ms | 14 ms | 29 ms | 96 ms | ville-dijon-760.avif | 17 ko | High | 2 · 75 ko · fin 95 ms | 2 · 14 ko · fin 95 ms |


---

## Ce que l'expérience a démenti — le CSS critique

`CLAUDE.md` §8 demande un CSS critique, et le raisonnement était clair : un LCP texte est peint dès
que le HTML et la CSS sont là, donc supprimer l'aller-retour de la feuille devrait le devancer.
**La mesure dit le contraire.**

Un extracteur a été écrit (`tools/extraire-css-critique.mjs`) : il relève les règles réellement
appliquées au premier écran des 53 routes, à 375 px et à 1440 px, et n'en garde aucune qui ne vise
un élément visible. Résultat : 317 règles sur 741, **40 Ko minifiés**. Mis en ligne dans le `<head>`,
la feuille complète passée en `preload` + bascule :

| Mesure mobile | Avant | Avec CSS critique | Avec CSS critique **et** aucune feuille bloquante |
|---|---:|---:|---:|
| Accueil | 2,87 s | **3,02 s** | **3,01 s** |
| Prestation | 2,87 s | **3,01 s** | **3,01 s** |
| Ville | 2,87 s | **3,02 s** | — |
| Article | 2,42 s | **2,56 s** | — |

Le dispositif **dégrade** le LCP de 0,14 s, et vider entièrement la chaîne bloquante n'y change
rien. La conclusion se lit d'un trait : **l'aller-retour de la feuille n'était pas le goulot**. Les
40 Ko en ligne font passer le HTML transféré de 12 à 19,4 Ko, et c'est ce poids-là qui se paie.

Le dispositif a donc été **retiré du thème**. L'extracteur reste au dépôt : il a produit la mesure,
et il permet de la refaire plutôt que de re-supposer. C'est la deuxième fois que ce chemin est
tenté — le 9 août 2026, une bascule sans CSS critique avait produit un CLS de 1,002 — et la trace
écrite est ce qui évite une troisième.

## La vraie cause : sept fichiers de police pour deux polices

Le poids total de l'accueil était de **341 Ko, dont 264 Ko de polices** — 78 % de la page, pour deux
familles. Sept fichiers chargés au premier écran, et le relevé réseau montrait pourquoi :

| Fichier | Poids |
|---|---:|
| `bricolage-grotesque-800-latin.woff2` | 41 611 o |
| `bricolage-grotesque-700-latin.woff2` | 41 611 o |
| `bricolage-grotesque-600-latin.woff2` | 41 611 o |
| `hanken-grotesk-400/500/600/700-latin.woff2` | 34 971 o **chacun** |

Des tailles rigoureusement identiques d'une graisse à l'autre : ce ne sont pas sept polices, **c'est
le même fichier variable téléchargé sept fois**.

Les deux familles sont des polices variables. Demandées à Google graisse par graisse
(`wght@400;500;600;700;800`), l'API renvoie quinze déclarations `@font-face` qui pointent toutes
vers **trois URL** — le même woff2 par sous-ensemble. Le téléchargeur en faisait quinze fichiers de
noms différents, et le navigateur, ne pouvant deviner qu'ils sont identiques, en chargeait sept.

Demandées en plage (`wght@400..800`), les mêmes octets arrivent en **un fichier par famille et par
sous-ensemble**, avec `font-weight: 400 800`. Dix-huit fichiers deviennent quatre ; l'accueil en
charge **deux** au lieu de sept.

**Le rendu ne peut pas changer** : ce sont les mêmes glyphes, issus du même fichier. Seul le nombre
de téléchargements change.

Le téléchargeur refuse désormais de continuer si Google renvoie une graisse fixe ou deux fichiers
distincts pour un même sous-ensemble : sans cette garde, la régression reviendrait sans bruit.

## Résultat mesuré

| Route | LCP mobile avant | après | LCP bureau avant | après |
|---|---:|---:|---:|---:|
| Accueil | 2,87 s | **1,82 s** | 0,61 s | 0,44 s |
| Prestation | 2,87 s | **1,82 s** | 0,58 s | 0,42 s |
| Ville | 2,87 s | **1,82 s** | 0,58 s | 0,42 s |
| Tarifs | 2,72 s | **1,66 s** | 0,58 s | 0,37 s |
| Article | 2,42 s | **1,82 s** | 0,56 s | 0,42 s |
| Contact | 2,42 s | **1,66 s** | 0,54 s | 0,41 s |
| Formulaire de devis | 2,50 s | **1,67 s** | 0,54 s | 0,39 s |

**Les sept routes passent sous 2,5 s, avec 0,7 s de marge.** Performance mobile de 93-97 à
**99-100**, bureau 100 partout. **CLS 0,000 sur les quatorze mesures** : le préchargement qui
corrigeait le CLS de 0,25 en G24 est préservé — il porte deux fichiers au lieu de quatre, et couvre
davantage de graisses puisqu'elles sortent toutes du même fichier.

## Ce qui reste écarté, et pourquoi

| Levier | Décision |
|---|---|
| Retirer la feuille du thème parent | **Écarté** : non mesurable honnêtement ici — 47 octets sur le banc, styles de base en production. Et devenu sans objet, la chaîne bloquante n'étant pas le goulot. |
| Réduire encore les préchargements | **Écarté** : ils corrigent un CLS mesuré à 0,25 (G24). Deux fichiers suffisent désormais. |
| Compresser l'image LCP | **Sans objet** : 17 Ko, priorité High, 26 ms de transfert. |
