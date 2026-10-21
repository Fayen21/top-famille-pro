# Réconciliation des décomptes de ratios

> Fichier **généré** par `node tools/reconcilier-ratios.mjs`. Ne pas éditer à la main.

## Deux instruments, deux totaux — et la confusion qu'ils ont produite

Un rapport a annoncé « 318 contrôles · 298 dans 95-105 % » et « 19 ratios hors bande » dans
le même paragraphe. 318 − 298 = **20**, pas 19. Les deux chiffres étaient exacts, et ne
parlaient pas de la même chose. Rien ne le disait : c'est le défaut, pas les chiffres.

| | Relevé de base | Comparaison des routes |
|---|---|---|
| Fichier | `docs/baseline.json` | `docs/COMPARAISON-53-ROUTES.md` |
| Largeurs | 320, 375, 768, 1024, 1440, 1920 | 375 et 1440 |
| Mesure par route et par largeur | hauteur de page, **une seule** | hauteur **et** nombre de mots |
| Total de contrôles | 53 × 6 = **318** | 53 × 2 × 2 = **212** |
| Dans 95-105 % | **300** | **193** |
| Hors bande | **18** | **19** |
| Vérification | 300 + 18 = 318 ✅ | 193 + 19 = 212 ✅ |

Le « 20 » appartient au relevé de base, le « 19 » à la comparaison. Ils ne s'additionnent pas,
ne se soustraient pas, et ne se citent pas côte à côte sans nommer leur instrument.

## Relevé de base — les 18 contrôles hors bande

| Route | Largeur | Ratio | Type de page | Motif | Statut |
|---|---:|---:|---|---|---|
| `#/gestion-des-cookies` | 320 px | 120 % | légale | Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/gestion-des-cookies` | 375 px | 119 % | légale | Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/gestion-des-cookies` | 768 px | 111 % | légale | Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/gestion-des-cookies` | 1024 px | 112 % | légale | Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/gestion-des-cookies` | 1440 px | 122 % | légale | Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/gestion-des-cookies` | 1920 px | 122 % | légale | Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/mentions-legales` | 320 px | 123 % | légale | Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/mentions-legales` | 375 px | 124 % | légale | Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/mentions-legales` | 768 px | 120 % | légale | Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/mentions-legales` | 1024 px | 123 % | légale | Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/mentions-legales` | 1440 px | 132 % | légale | Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/mentions-legales` | 1920 px | 133 % | légale | Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/politique-de-confidentialite` | 320 px | 135 % | légale | Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/politique-de-confidentialite` | 375 px | 136 % | légale | Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/politique-de-confidentialite` | 768 px | 130 % | légale | Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/politique-de-confidentialite` | 1024 px | 131 % | légale | Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/politique-de-confidentialite` | 1440 px | 143 % | légale | Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n'en pose qu'un résumé. | contenu légal imposé |
| `#/politique-de-confidentialite` | 1920 px | 143 % | légale | Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n'en pose qu'un résumé. | contenu légal imposé |

## Comparaison des routes — les 19 ratios hors bande

| Route | Largeur | Mesure | Ratio | Statut | Motif |
|---|---:|---|---:|---|---|
| `#/` | 375 px | mots | 106 % | ajouts imposés par le brief | +89 mots relevés un par un : lien d'évitement, noms accessibles des déplieurs de menu, exclusions réelles et mention « matériel fourni par le client » (CLAUDE.md §9), mentions de contenu provisoire et « citation en attente de validation » (§5.5), coordonnées du pied. |
| `#/demande-de-devis` | 375 px | mots | 110 % | différence fonctionnelle obligatoire | Formulaire réel : libellés, aides de saisie, messages d'erreur, mentions de consentement. La maquette dessine des champs, elle n'en fait pas fonctionner. |
| `#/contact` | 375 px | mots | 115 % | différence fonctionnelle obligatoire | Idem : le formulaire de contact est réel, avec ses libellés et ses messages. |
| `#/mentions-legales` | 375 px | hauteur | 124 % | contenu légal imposé | Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n'en pose qu'un résumé. |
| `#/mentions-legales` | 375 px | mots | 136 % | contenu légal imposé | Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n'en pose qu'un résumé. |
| `#/politique-de-confidentialite` | 375 px | hauteur | 136 % | contenu légal imposé | Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n'en pose qu'un résumé. |
| `#/politique-de-confidentialite` | 375 px | mots | 158 % | contenu légal imposé | Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n'en pose qu'un résumé. |
| `#/gestion-des-cookies` | 375 px | hauteur | 119 % | contenu légal imposé | Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n'en pose qu'un résumé. |
| `#/gestion-des-cookies` | 375 px | mots | 138 % | contenu légal imposé | Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n'en pose qu'un résumé. |
| `#/` | 1440 px | mots | 107 % | ajouts imposés par le brief | +89 mots relevés un par un : lien d'évitement, noms accessibles des déplieurs de menu, exclusions réelles et mention « matériel fourni par le client » (CLAUDE.md §9), mentions de contenu provisoire et « citation en attente de validation » (§5.5), coordonnées du pied. |
| `#/avis-clients` | 1440 px | mots | 106 % | ajouts imposés par le brief | Mention « Exemple de présentation — témoignages authentiques en cours d'intégration », exigée par CLAUDE.md §5.5 au-dessus de la grille d'avis provisoires. |
| `#/demande-de-devis` | 1440 px | mots | 112 % | différence fonctionnelle obligatoire | Formulaire réel : libellés, aides de saisie, messages d'erreur, mentions de consentement. La maquette dessine des champs, elle n'en fait pas fonctionner. |
| `#/contact` | 1440 px | mots | 117 % | différence fonctionnelle obligatoire | Idem : le formulaire de contact est réel, avec ses libellés et ses messages. |
| `#/mentions-legales` | 1440 px | hauteur | 132 % | contenu légal imposé | Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n'en pose qu'un résumé. |
| `#/mentions-legales` | 1440 px | mots | 136 % | contenu légal imposé | Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n'en pose qu'un résumé. |
| `#/politique-de-confidentialite` | 1440 px | hauteur | 143 % | contenu légal imposé | Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n'en pose qu'un résumé. |
| `#/politique-de-confidentialite` | 1440 px | mots | 157 % | contenu légal imposé | Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n'en pose qu'un résumé. |
| `#/gestion-des-cookies` | 1440 px | hauteur | 122 % | contenu légal imposé | Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n'en pose qu'un résumé. |
| `#/gestion-des-cookies` | 1440 px | mots | 139 % | contenu légal imposé | Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n'en pose qu'un résumé. |

## Objectif

Les trois pages légales font 18 contrôles (3 routes × 6 largeurs) : elles sont autorisées hors
tolérance. L'objectif est donc **300 / 318**, soit les 50 routes non légales dans la bande aux
six largeurs.

**État : 300 / 318** — 0 défaut(s) restant(s).

