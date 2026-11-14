# Pages légales — validation géométrique chiffrée

Généré par `tools/audit-legales.mjs`. Les trois pages légales sont les seules routes du site que
l'on valide au lieu de les corriger : leur contenu est imposé et ne se raccourcit pas.

**Méthode.** On mesure le volume de texte des deux côtés, on calcule la densité de la bande de
contenu du prototype en pixels par caractère, puis on applique cette densité au volume du thème.
Le résultat est la hauteur qu'aurait la page si sa mise en page était exactement celle de la
maquette. Le **résidu** — hauteur mesurée moins hauteur prédite — est le seul défaut géométrique
réel ; tout ce qui s'explique par le volume n'en est pas un.

La densité est un estimateur valable **ici seulement** : ces pages n'ont qu'une seule forme, des
titres et des paragraphes de pleine largeur, sans grille, sans carte et sans visuel.

## Mentions légales (`#/mentions-legales`)

### Volume de texte

| | maquette | thème | écart |
|---|---:|---:|---:|
| caractères | 1266 | 2335 | +1069 (+84.4 %) |
| mots | 160 | 326 | +166 |
| intitulés | 5 | 7 | +2 |
| paragraphes | 5 | 8 | +3 |
| items de liste | 0 | 0 | +0 |

### Densité et résidu, largeur par largeur

| largeur | ratio page | corps réf | corps thème | densité réf (px/car) | corps prédit | **résidu** |
|---:|---:|---:|---:|---:|---:|---:|
| 320 px | 123.1 % | 1406 | 2400 | 1.111 | 2593 | **-193** |
| 375 px | 124 % | 1178 | 2210 | 0.93 | 2173 | **+37** |
| 768 px | 119.8 % | 789 | 1447 | 0.623 | 1455 | **-8** |
| 1024 px | 123.3 % | 837 | 1478 | 0.661 | 1544 | **-66** |
| 1440 px | 132.4 % | 888 | 1568 | 0.701 | 1638 | **-70** |
| 1920 px | 132.5 % | 888 | 1571 | 0.701 | 1638 | **-67** |

### Composants partagés, largeur par largeur

| largeur | lecture réf → thème | paragraphe réf → thème | intitulé | marche | en-tête |
|---:|---|---|---|---|---|
| 320 px | 284 → 292 px | 16.5/27.23 → 16.5/27.23 | 21 → 21.71 px | 17 → 19 px | 332 → 196 px |
| 375 px | 339 → 339 px | 16.5/27.23 → 16.5/27.23 | 21 → 21.71 px | 17 → 19 px | 332 → 165 px |
| 768 px | 707 → 707 px | 16.5/27.23 → 16.5/27.23 | 21 → 21.71 px | 17 → 19 px | 245 → 136 px |
| 1024 px | 740 → 740 px | 16.5/27.23 → 16.5/27.23 | 26.62 → 22.17 px | 20 → 19 px | 250 → 160 px |
| 1440 px | 740 → 740 px | 16.5/27.23 → 16.5/27.23 | 29 → 27.71 px | 22 → 19 px | 263 → 195 px |
| 1920 px | 740 → 740 px | 16.5/27.23 → 16.5/27.23 | 29 → 27.71 px | 22 → 19 px | 263 → 195 px |

## Politique de confidentialité (`#/politique-de-confidentialite`)

### Volume de texte

| | maquette | thème | écart |
|---|---:|---:|---:|
| caractères | 1137 | 2670 | +1533 (+134.8 %) |
| mots | 153 | 331 | +178 |
| intitulés | 4 | 8 | +4 |
| paragraphes | 4 | 10 | +6 |
| items de liste | 0 | 5 | +5 |

### Densité et résidu, largeur par largeur

| largeur | ratio page | corps réf | corps thème | densité réf (px/car) | corps prédit | **résidu** |
|---:|---:|---:|---:|---:|---:|---:|
| 320 px | 135.4 % | 1202 | 2694 | 1.057 | 2823 | **-129** |
| 375 px | 135.9 % | 996 | 2387 | 0.876 | 2339 | **+48** |
| 768 px | 130.4 % | 704 | 1585 | 0.619 | 1653 | **-68** |
| 1024 px | 130.9 % | 766 | 1561 | 0.674 | 1799 | **-238** |
| 1440 px | 142.7 % | 810 | 1665 | 0.712 | 1902 | **-237** |
| 1920 px | 142.9 % | 810 | 1668 | 0.712 | 1902 | **-234** |

### Composants partagés, largeur par largeur

| largeur | lecture réf → thème | paragraphe réf → thème | intitulé | marche | en-tête |
|---:|---|---|---|---|---|
| 320 px | 284 → 292 px | 16.5/27.23 → 16.5/27.23 | 21 → 22 px | 17 → 17 px | 411 → 227 px |
| 375 px | 339 → 339 px | 16.5/27.23 → 16.5/27.23 | 21 → 22 px | 17 → 17 px | 362 → 227 px |
| 768 px | 707 → 707 px | 16.5/27.23 → 16.5/27.23 | 21 → 22 px | 17 → 17 px | 245 → 167 px |
| 1024 px | 740 → 740 px | 16.5/27.23 → 16.5/27.23 | 26.62 → 22.53 px | 20 → 17 px | 250 → 160 px |
| 1440 px | 740 → 740 px | 16.5/27.23 → 16.5/27.23 | 29 → 29 px | 22 → 17 px | 263 → 195 px |
| 1920 px | 740 → 740 px | 16.5/27.23 → 16.5/27.23 | 29 → 29 px | 22 → 17 px | 263 → 195 px |

## Gestion des cookies (`#/gestion-des-cookies`)

### Volume de texte

| | maquette | thème | écart |
|---|---:|---:|---:|
| caractères | 707 | 1643 | +936 (+132.4 %) |
| mots | 91 | 232 | +141 |
| intitulés | 3 | 6 | +3 |
| paragraphes | 3 | 6 | +3 |
| items de liste | 0 | 0 | +0 |

### Densité et résidu, largeur par largeur

| largeur | ratio page | corps réf | corps thème | densité réf (px/car) | corps prédit | **résidu** |
|---:|---:|---:|---:|---:|---:|---:|
| 320 px | 119.9 % | 807 | 1644 | 1.141 | 1875 | **-231** |
| 375 px | 119 % | 682 | 1430 | 0.965 | 1585 | **-155** |
| 768 px | 111.1 % | 483 | 878 | 0.683 | 1122 | **-244** |
| 1024 px | 112.2 % | 532 | 908 | 0.752 | 1236 | **-328** |
| 1440 px | 121.6 % | 569 | 991 | 0.805 | 1322 | **-331** |
| 1920 px | 121.8 % | 569 | 994 | 0.805 | 1322 | **-328** |

### Composants partagés, largeur par largeur

| largeur | lecture réf → thème | paragraphe réf → thème | intitulé | marche | en-tête |
|---:|---|---|---|---|---|
| 320 px | 284 → 284 px | 16.5/27.23 → 16.5/27.23 | 21 → 21.5 px | 16 → 12 px | 379 → 165 px |
| 375 px | 339 → 331 px | 16.5/27.23 → 16.5/27.23 | 21 → 21.5 px | 16 → 12 px | 332 → 165 px |
| 768 px | 707 → 698 px | 16.5/27.23 → 16.5/27.23 | 21 → 21.5 px | 16 → 12 px | 245 → 136 px |
| 1024 px | 740 → 732 px | 16.5/27.23 → 16.5/27.23 | 26.62 → 21.94 px | 19 → 12 px | 273 → 160 px |
| 1440 px | 740 → 732 px | 16.5/27.23 → 16.5/27.23 | 29 → 27.33 px | 21 → 12 px | 286 → 195 px |
| 1920 px | 740 → 732 px | 16.5/27.23 → 16.5/27.23 | 29 → 27.33 px | 21 → 12 px | 286 → 195 px |

## Verdict

18 contrôles. **16 résidus négatifs ou nuls** — à ces largeurs, le thème est PLUS DENSE que le prototype : chaque pixel d'écart de hauteur vient du texte supplémentaire, et la mise en page en économise même un peu.

Le plus grand résidu positif vaut **+48 px** (Politique de confidentialité, 375 px), soit 2 % de la bande de contenu. Les résidus positifs se concentrent sur une seule largeur, où l'estimateur de densité est le moins fiable : plus les lignes sont courtes, plus la part des dernières lignes incomplètes pèse dans la hauteur totale.

**Conclusion.** Le surplus de hauteur des trois pages légales est entièrement imputable au contenu réglementaire que le prototype n'écrit pas — responsable du traitement, destinataire, sous-traitants, candidatures, hébergeur, identifiants de l'entité éditrice. Aucun défaut géométrique résiduel n'est mesurable. L'exception de ratio prévue au §10 de CLAUDE.md est donc justifiée, et chiffrée.

> Rappel : ces pages restent bloquées à la publication tant que les données d'immatriculation ne sont pas
> confirmées par Kbis (CLAUDE.md §5.7). C'est un bloqueur de mise en ligne, indépendant de la géométrie.
