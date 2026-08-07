# Design tokens — extraits du prototype

> Le prototype (`reference/Top-Famille-Pro-HANDOFF-READY.html`) n'a **aucun fichier de tokens
> centralisé** : toutes les valeurs ci-dessous sont des `style="..."` inline répétés à l'identique
> des centaines de fois. C'est exactement le problème que CLAUDE.md §4 demande de corriger :
> « Les styles inline du prototype deviennent des composants et des tokens centralisés ». Ce
> document liste les valeurs réellement observées (comptage d'occurrences dans le bundle), pour
> servir de base à un fichier de tokens propre en phase 1 (variables CSS / SCSS / JSON selon le
> choix retenu).
>
> Méthode : extraction automatisée par `grep`/`node` sur le CSS de base (`<style>` du template) et
> sur les `style="..."` inline de la page d'accueil pré-rendue (seule page dont le HTML complet est
> présent dans le bundle ; les autres routes sont produites côté client par le même moteur de
> composants, donc les mêmes valeurs).

---

## 1. Couleurs

Comptage = nombre d'occurrences dans le bundle (base CSS + inline styles de la page d'accueil).
Le rôle est déduit du contexte (sélecteur, propriété, élément porteur), pas déclaré explicitement
par le prototype — à confirmer/nommer définitivement en phase 1.

### Palette principale (bleu nuit / bleu / turquoise / cuivre — CLAUDE.md §4)

| Hex | Occurrences | Rôle observé |
|---|---|---|
| `#10263B` | 74 | **Bleu nuit** — fond du header sticky en scroll, fond de sections sombres, texte sur boutons cuivre |
| `#174A81` | 363 | **Bleu principal** — couleur de lien de base (`a{color:#174A81}`), `::selection`, `:focus-visible`, CTA principaux, icônes |
| `#1B3550` | 28 | Bleu foncé secondaire — variante de fond de carte/section |
| `#234066` | 19 | Bleu foncé secondaire — variante de fond de carte/section |
| `#2C5E8C` | 8 | Bleu — variante de survol/état |
| `#1E5C9E` | 6 | Bleu — variante de survol/état |
| `#93DADB` | 119 | **Turquoise clair** — accents de texte sur fond sombre, séparateurs `border-left` |
| `#B8E4E4` | 80 | Turquoise clair — fond de badge/chip |
| `#DDF4F3` | 55 | Turquoise très clair — fond de bloc de réassurance |
| `#CDEBEA` | 5 | Turquoise très clair — variante de fond |
| `#D9A062` | 16 | **Accent cuivre** — CTA principal (`background:#D9A062`), bordures d'accent |
| `#A8622E` | 19 | Cuivre foncé — texte sur badge cuivre clair |
| `#F6E5CF` | 18 | Cuivre très clair — fond de badge/pastille cuivre |
| `#EBB878` | 10 | Cuivre clair — variante de fond |
| `#FCEFE0` | 3 | Cuivre très clair — variante de fond |
| `#E8C79B` | 3 | Cuivre clair — variante de fond |
| `#C88C4C` | 1 | Cuivre — variante |
| `#7A4E1E` | 3 | Cuivre foncé — variante de texte |
| `#F0B87A` | 2 | Cuivre clair — variante |

### Neutres bleu-gris (texte, fonds, bordures)

| Hex | Occurrences | Rôle observé |
|---|---|---|
| `#18232D` | 127 | **Texte principal** (`body{color:#18232D}`), titres |
| `#4A6273` | 178 | Texte secondaire / paragraphes |
| `#58717F` | 151 | Texte tertiaire / légendes |
| `#34485A` | 105 | Texte sur fond clair, variante intermédiaire |
| `#2C3B48` | 76 | Texte foncé secondaire |
| `#8FAEB9` | 36 | Texte discret / placeholder |
| `#7FAEBF` | 8 | Variante bleu-gris |
| `#B7C6CD` | 3 | Bordure claire |
| `#3E5468` | 3 | Texte foncé, variante |
| `#5D7684` | 1 | Texte, variante |
| `#7B939F` | 1 | Texte discret, variante |
| `#0B1B2B` | 1 | Quasi-noir, variante ponctuelle |

### Fonds clairs

| Hex | Occurrences | Rôle observé |
|---|---|---|
| `#FFFFFF` (`#fff`) | 383 | Fond de carte, header non scrollé |
| `#F4F7F8` | 89 | **Fond de page** (`body{background:#F4F7F8}`) |
| `#DCE7EB` | 233 | Fond de carte / placeholder image |
| `#E4EDF0` | 92 | Fond de section alterné |
| `#C6DCE4` | 98 | Fond de bloc, bordure |
| `#C9DCE2` | 34 | Fond de bloc, variante |
| `#B7CFD7` | 31 | Bordure / fond discret |
| `#EDF5F6` | 15 | Fond de bloc clair |

### Sémantique (succès / erreur / marque tierce)

| Hex | Occurrences | Rôle observé |
|---|---|---|
| `#1E6B4C` | 14 | Vert — bordure de badge de réassurance (garantie, assurance) |
| `#0F3325` | 10 | Vert très foncé — fond de badge de réassurance |
| `#B7E7CE` | 15 | Vert clair — fond de badge succès |
| `#12402E` | 2 | Vert foncé — variante |
| `#EA4335` `#4285F4` `#FBBC05` `#34A853` | 6/6/3/3 | **Couleurs de marque Google** — utilisées lettre par lettre pour composer le mot « Google » dans le bloc avis (`<span style="color:#4285F4">G</span>...`). ⚠️ Une marque tierce encodée en dur dans le contenu : à revoir en composant SVG (logo Google officiel) plutôt qu'en texte coloré lettre à lettre. |
| `#FF9A9A` `#EA4335`(dup) `#8A2B2B` `#7A3030` `#4A1E1E` `#FDECEC` `#F1C9C9` `#E9B4B4` | 6/—/3/1/1/1/1/1 | Rouge — états d'erreur de formulaire (bordure, fond, texte) |
| `#EAB308` | 25 | Jaune ambre — étoiles de notation (avis) |

---

## 2. Typographie

Polices déclarées dans le prototype (via `@font-face`, Google Fonts) : **Bricolage Grotesque**
(titres) et **Hanken Grotesk** (texte) — conforme à CLAUDE.md §4. Sept fichiers `.woff2` sont
embarqués dans le bundle du prototype (variantes de sous-ensembles Unicode latin/latin-ext/vietnamese).

```css
body { font-family: 'Hanken Grotesk', system-ui, -apple-system, sans-serif; line-height: 1.62; font-size: 17px; }
h1, h2, h3, h4, h5 {
  font-family: 'Bricolage Grotesque', 'Hanken Grotesk', sans-serif;
  line-height: 1.04;
  letter-spacing: -0.02em;
  font-weight: 700;
  text-wrap: balance;
}
p { text-wrap: pretty; }
```

### Échelle de tailles observées (page d'accueil, occurrences)

| Taille | Occurrences | Usage probable |
|---|---|---|
| 38px | 2 | H1 hero |
| 34px | 1 | Titre de section large |
| 32px | 3 | Titre de section |
| 30px | 5 | Titre de section |
| 26px | 9 | Titre de section / H2 |
| 24px | 4 | Sous-titre |
| 22px | 16 | Titre de carte |
| 20px | 22 | Titre de carte / chiffre clé |
| 19px | 21 | Intertitre |
| 18px | 43 | Texte large / lede |
| 18.5px | 7 | Variante |
| 17px | 79 | Texte courant (= taille de base `body`) |
| 16px | 79 | Texte courant |
| 16.5px | 84 | Variante texte courant |
| 15px | 164 | Texte secondaire |
| 15.5px | 86 | Variante |
| 14px | 132 | Texte petit (labels, méta) |
| 14.5px | 124 | Variante |
| 13px | 58 | Petit texte (badges, légendes) |
| 13.5px | 55 | Variante |
| 12px | 33 | Micro-texte |
| 12.5px | 54 | Variante |
| 11px / 11.5px | 2 / 30 | Micro-label |
| 10.5px | 3 | Micro-label |
| 8px | 2 | Ponctuel (indicateur minuscule) |

**Observation à corriger en phase 1** : la multiplication de tailles à 0,5px près (14px/14.5px/15px/15.5px…)
n'est pas une échelle typographique volontaire — c'est un artefact du prototypage libre. Un vrai
système de tokens doit réduire ceci à une échelle discrète (ex. 12/13/14/16/17/19/22/26/32/38px).

### Graisses observées

| `font-weight` | Occurrences | Usage |
|---|---|---|
| 400 | 22 | Texte courant (implicite la plupart du temps, hérité du `body`) |
| 500 | 21 | Texte moyen |
| 600 | 274 | Sous-titres, labels forts, boutons secondaires |
| 700 | 349 | Titres (`h1`-`h5`), boutons, chiffres clés |
| 800 | 91 | Titres impactants (hero, chiffres de réassurance) |

---

## 3. Espacements, rayons, ombres

### Rayons de bordure (`border-radius`)

| Valeur | Occurrences | Usage probable |
|---|---|---|
| 2px / 3px | 7 / 10 | Détail fin (soulignement, puce) |
| 4px / 5px | 1 / 1 | Ponctuel |
| 9px / 10px / 11px | 9 / 37 / 18 | Boutons compacts, badges |
| 12px | 129 | **Rayon standard carte/bouton** (le plus fréquent) |
| 13px / 14px | 1 / 76 | Carte, second rayon standard |
| 16px | 48 | Carte large, image |
| 18px | 19 | Carte hero, bloc large |
| 20px | 19 | Bloc large |
| 100px | 56 | **Pilule** (badges, boutons ronds, chips) |

Piste de tokens : `--radius-sm: 10px`, `--radius-md: 12px`, `--radius-lg: 16px`, `--radius-xl: 20px`,
`--radius-pill: 100px`.

### Ombres (`box-shadow`)

| Valeur | Occurrences | Usage probable |
|---|---|---|
| `0 14px 26px -16px rgba(16,38,59,.25)` | 5 | Ombre carte niveau 1 |
| `0 16px 34px -22px rgba(16,38,59,.3)` | 8 | Ombre carte niveau 2 (la plus fréquente) |
| `0 22px 50px -16px rgba(16,38,59,.22)` | 2 | Ombre bloc large / modale |
| `0 0 0 3px rgba(147,218,219,.35)` | 5 | Anneau de focus turquoise (alternative à `:focus-visible`) |
| `0 8px 20px -10px rgba(217,160,98,.9)` | 1 | Ombre CTA cuivre |
| `0 12–18px … rgba(16,38,59,.4–.5)` | ~6 | Variantes d'ombre de carte au survol |
| `0 12–14px … rgba(14,92,70,.6–.7)` | 2 | Ombre badge vert (réassurance) |

Toutes les ombres partagent la même teinte de base `rgba(16,38,59,*)` (= bleu nuit `#10263B`) : bon
signe pour la tokenisation (`--shadow-color: 16, 38, 59`).

### Espacements (`gap`, `padding`)

`gap` observés (px) : 1, 2, 5, 6, 7, 8, 9, 10, 12, 14, 15, 16, 18, 20, 32 — cluster dominant à
6/8/9/10/12/14/16px. `padding` en grande majorité sur deux valeurs combinées (ex. `18px 20px`,
`13px 15px`, `15px 24px`), cohérent avec une échelle 8px avec quelques demi-pas.

Piste de tokens (échelle proche de 4/8px) : `4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 32px`.

### Durées de transition

`0.15s`, `0.2s`, `0.25s`, `0.3s`, `0.5s`, `0.6s` selon la propriété (couleur = rapide, transform = plus lent).
Toutes les animations doivent rester conditionnées à `prefers-reduced-motion` (déjà fait pour le
scroll fluide dans le code du prototype — `ui.toTop`, à généraliser en phase 1, cf. CLAUDE.md §8).

---

## 4. Breakpoints

Valeurs de `max-width`/`min-width` observées dans les media queries et calculs de layout :

| Valeur | Occurrences | Rôle probable |
|---|---|---|
| 520px | 8 | Mobile étroit |
| 540px | 6 | Mobile |
| 560px | 7 | Mobile large |
| 600px | 4 | Mobile large / bascule de grille |
| 620px | 7 | Charnière mobile/tablette |
| 640px | 9 | Charnière mobile/tablette |
| 660px | 5 | Tablette étroite |
| 680px | 12 | Tablette étroite |
| 760px | 5 | Tablette |
| 768px | 2 | **Tablette portrait** (standard) |
| 820px | 27 | Tablette / bascule menu mobile ↔ desktop |
| 860px | 8 | Charnière tablette/desktop |
| 900px | 32 | Petit desktop / bascule 2 colonnes |
| 1040px | 15 | Desktop |
| 1100px | 3 | Desktop |
| 1260px | 104 | **Largeur maximale de conteneur** (le plus fréquent, de loin) |

Le conteneur principal semble donc plafonné à **1260px**, avec un point de bascule menu
mobile/desktop autour de **820px**. Ceci est cohérent avec les largeurs de test demandées en phase 5
(320/375/768/1024/1440/1920) mais montre que le prototype utilise ses propres charnières
intermédiaires (520/620/680/860/900/1040) plutôt qu'une échelle de breakpoints ronde — à trancher
et réduire en phase 1 (ex. `--bp-sm: 640px`, `--bp-md: 820px`, `--bp-lg: 1040px`, `--bp-xl: 1260px`).

---

## 5. Base CSS globale observée (à reprendre comme fondation du thème enfant)

```css
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'Hanken Grotesk', system-ui, -apple-system, sans-serif;
  color: #18232D;
  background: #F4F7F8;
  -webkit-font-smoothing: antialiased;
  line-height: 1.62;
  font-size: 17px;
}
a { color: #174A81; text-decoration: none; transition: color .15s ease; }
a:hover { color: #10263B; }
::selection { background: #174A81; color: #fff; }
:focus-visible { outline: 2px solid #174A81; outline-offset: 2px; }
```

`:focus-visible` est déjà présent dans le prototype — bon point de départ pour l'exigence
d'accessibilité « focus visible et restitué » de CLAUDE.md §8.
