# Rapport de clôture — fidélité Claude Design

> Branche `hotfix-production-fidelite-claude-design`, PR #9, commit `07db33e` (13 septembre 2026).
> **Rien n'a été fusionné dans `main`, rien n'a été déployé, ni la production ni les DNS n'ont été
> touchés.**
>
> Ce fichier est réécrit d'un bloc à chaque clôture, jamais complété par accrétion. La version
> précédente datait du 12 août et décrivait encore un relevé à 187/318 : un rapport de clôture qui
> recopie des mesures antérieures à ses propres correctifs décrit un site qui n'existe plus.
> **Tous les chiffres ci-dessous ont été remesurés sur le commit qu'annonce l'en-tête.**

---

## 1. Verdict

**`PARTIEL — ÉCARTS RESTANTS`.**

Ce verdict ne désigne plus aucun défaut de thème. Il désigne exactement deux choses, et aucune
n'est du code :

1. **La validation humaine du dossier G28** — 110 comparaisons soumises au jugement, toutes au
   statut `À VALIDER`, aucune case pré-remplie.
2. **L'envoi réel du formulaire de devis** — le seul test qui ne peut pas être joué depuis
   l'environnement de développement, faute de transport mail.

Les sept causes `DEFAUT_THEME` qui portaient ce verdict à la clôture précédente sont corrigées :
`docs/anomalies-g22.json` donne `defauts_reels_non_corriges: 0` et `defauts_theme_restants: 0`.

---

## 2. Ce que cette clôture a réuni

Le chantier s'est scindé en deux troncs pendant trois semaines : la PR #9 d'un côté, une branche
de travail portant G23 à G28 de l'autre. **Soixante-quatre commits de travail fini vivaient hors
de toute PR.** Le symptôme était mesurable et trompeur : rejouer Lighthouse sur la branche de la
PR donnait sept échecs et un LCP mobile à 2,88 s, non parce que le site était lent, mais parce que
le correctif qui le rend rapide était ailleurs.

Les deux histoires sont réunies (`906ad57`), puis **tout a été régénéré sur l'état fusionné**
(`07db33e`) : mesures, planches, exports et archives. Aucun chiffre de ce rapport ne provient d'un
des deux états antérieurs.

---

## 3. Fidélité — relevé de base

`docs/baseline-g27-final.json`, 53 routes × 6 largeurs.

| | |
|---|---|
| Contrôles | **318 / 318** |
| Dans la tolérance 95–105 % | **298** |
| Débordement horizontal | **0** |
| Images cassées | **0** |
| Erreurs console ou réseau | **0** |

Les vingt contrôles hors plage se répartissent ainsi : **dix-huit sont les trois pages légales aux
six largeurs**, exception chiffrée et justifiée au §5 ; les deux derniers sont `#/avis-clients` à
deux largeurs.

L'exception légale n'est pas une tolérance accordée : elle est démontrée. Voir §5.

---

## 4. Anomalies — classement clos

| | Avant | Après |
|---|---:|---:|
| Anomalies | 348 | **215** |
| Occurrences | 128 | **7** |
| Causes | 9 | **4** |

`toutes_classees: true` · `zero_a_instruire: true` · `zero_preuve_insuffisante: true` ·
**`defauts_reels_non_corriges: 0`** · verdict du classement : `PASS`.

Aucune occurrence ne porte un statut d'attente. Les sept restantes sont classées en différence
éditoriale autorisée ou en différence légale imposée, chacune avec sa justification.

---

## 5. Pages légales — l'exception est mesurée, pas concédée

Les trois pages légales dépassent la maquette de 13 à 32 % selon la largeur. La méthode employée
interdit de conclure à un défaut géométrique sans le prouver : on mesure le **volume de texte** des
deux côtés, on calcule la **densité** de la bande de contenu du prototype en pixels par caractère,
on l'applique au volume du thème, et seul le **résidu** — hauteur mesurée moins hauteur prédite —
compte comme défaut.

Le texte réglementaire du thème pèse **+84 % à +135 %** de caractères de plus que celui du
prototype, qui omettait le responsable du traitement, les destinataires, les sous-traitants, les
candidatures, l'hébergeur et les identifiants de l'entité éditrice. Après correction des deux vrais
défauts trouvés au passage — largeur de lecture 760 px contre 820 relevés, paragraphes 17 px/1,7
contre 16,5/1,65 — **seize résidus sur dix-huit sont négatifs ou nuls**.

Le surplus est donc entièrement imputable au contenu réglementaire. Le comprimer reviendrait à
retirer des mentions obligatoires pour gagner un ratio.

---

## 6. Performance — Lighthouse

Mesuré sur `tools/banc-production.mjs`, qui place devant le rig la compression et les en-têtes de
cache d'un LiteSpeed Hostinger. Compression gzip et `cache-control: immutable` vérifiés avant le
lancement : mesurer sur le serveur PHP nu donnerait des chiffres qui n'existent sur aucun
hébergement.

**14 mesures sur 14 conformes.**

| | mobile | bureau |
|---|---|---|
| Performance | 99 – 100 | 100 |
| Accessibilité · Bonnes pratiques · SEO | 100 | 100 |
| LCP | **1,66 – 1,83 s** | 0,41 – 0,44 s |
| CLS | **0,000** | **0,000** |

Pour mémoire, la même commande sur la branche de la PR avant fusion : sept mesures sous la cible,
CLS bureau 0,028 et LCP mobile jusqu'à 2,88 s. L'écart n'est pas un gain de cette passe — c'est le
correctif de G27 qui devient mesurable ici.

---

## 7. Accessibilité

- **axe-core** : aucune violation, scans intégrés à la suite.
- **WCAG 2.2 AA 2.5.8 — cibles tactiles** : audit dédié sur les 53 routes à 1440 et 375 px,
  **aucune violation**, code de sortie 0.

Sur ce dernier point, un rappel qui a déjà coûté une passe : **44 × 44 px est le critère 2.5.5, de
niveau AAA**. Le critère AA visé est 2.5.8 — 24 × 24 px, ou espacement suffisant, ou l'exception
« inline ». Les avoir confondus avait inutilement gonflé la hauteur des pages de zone.

L'audit lui-même a été corrigé cette passe (FP11) : il comparait une barre d'action `position:
fixed` au contenu qu'elle survole, en lui fabriquant une position documentaire par
`top + scrollY`. Cette position glisse au défilement et dépend de la hauteur de fenêtre — la
violation était signalée à 900 px et muette à 800. Chaque cible porte désormais sa couche de
positionnement, et l'espacement ne compare que des cibles de même couche. Deux fixtures tiennent
les deux bouts : le faux positif disparaît, une vraie violation dans une seule couche reste
signalée.

---

## 8. Suite de tests

**1 255 tests, 0 échec**, captures comprises, banc en `development`.
Lint PHP : 82 fichiers OK. `bin/verifier-installation.php` : PASS.

---

## 9. Livraison

Paquet reconstruit par `npm run paquets`, qui contrôle la parité **avant et après** construction :
**1 265 fichiers comparés par empreinte**, archives conformes au dépôt.

| Fichier | Contenu |
|---|---|
| `release/topfamillepro-theme-correctif.zip` | thème enfant, **version 0.13.0**, 471 fichiers |
| `release/topfamillepro-content-installer-correctif.zip` | plugin d'installation, 20 fichiers |
| `release/Top-Famille-Pro-Correctif-Production.zip` | les deux ci-dessus + guide + informations manquantes + audit |
| `release/html-brut.zip` · `release/site-navigable.zip` | exports statiques |

Empreintes dans `release/SHA256SUMS-correctif.txt`. Le paquet réellement produit a été extrait dans
un répertoire neuf et vérifié — c'est lui qui part, pas le dossier de travail.

**Trois pièges de livraison ont été trouvés et traités dans cette passe :**

1. `tools/export-statique.mjs` **vide `export/`** : les paquets doivent être construits *après*
   l'export statique, jamais avant, sinon les archives disparaissent sans bruit.
2. **La version du thème ne bougeait pas** alors que son contenu changeait de 64 commits — un
   paquet indistinguable du précédent à l'installation, que WordPress ne signale pas comme une mise
   à jour. Passée de 0.12.0 à **0.13.0**.
3. `release/INFORMATIONS-MANQUANTES.md` réclamait encore la confirmation de la grille à trois
   montants (24,30 / 26,00 / 30,00 € HT/h). Ces montants ne sont plus servis nulle part : la
   demande portait sur un tarif mort et invitait à le rétablir. Elle vise désormais le **tarif
   unique de 27,00 € HT/h**.

Le test `tests/parite-installeur.spec.js` interdit désormais de livrer un ZIP en retard sur le
dépôt. Il a mordu dans cette passe : seul échec sur 1 166 au premier passage post-fusion, parce que
le paquet ne contenait pas encore la garde d'envoi du formulaire.

---

## 10. Exports statiques

53 routes · **0** statut non-200 · **0** ressource locale manquante · **0** fichier contenant
« localhost » · **0** image cassée sur 53 routes × 2 largeurs · **0** requête vers un domaine
externe · **53/53** ouvrables hors ligne.

Contrôle indépendant après coup, sur l'archive extraite dans un répertoire neuf : 58 pages, aucune
occurrence de « localhost », aucun chemin absolu.

---

## 11. Captures

88 contrôles rejoués **en une seule exécution**. Le jeu ne se régénère jamais par morceaux : une
exécution interrompue laisse quelques images à jour et le reste périmé, et le lot commité montre
alors certaines pages corrigées et d'autres non. C'est déjà arrivé une fois.

---

## 12. Formulaire de devis — prêt, sauf le seul test impossible d'ici

Le chemin d'envoi est complet et conforme au §8 de `CLAUDE.md` : validation serveur intégrale,
nonce, honeypot, limitation à 5 soumissions par heure et par IP, saisie conservée en cas d'erreur,
`Reply-To` du demandeur, **confirmation affichée uniquement après succès réel du serveur**, état de
confirmation en `noindex`.

**Un défaut réel a été trouvé et corrigé cette passe.** Le formulaire de contact portait depuis
longtemps une garde de neutralisation d'envoi ; le formulaire de devis n'en avait aucune. Il ne
devait sa sûreté qu'à l'absence de transport mail sur le banc — une circonstance, pas une garantie.
Sur une préproduction Hostinger, qui en a un, la suite fonctionnelle aurait expédié **six demandes
de devis à la gérante à chaque exécution**. Le devis a désormais la même garde, le gabarit expose
`data-tfp-mail-disabled`, et la suite se saute d'elle-même sur une installation qui expédie.

Effet de bord utile : le chemin de succès est devenu déterministe et **peut enfin être affirmé**.
Les deux tests de soumission complète ne vérifiaient que l'absence d'erreur de validation — ils
passaient sur un `erreur=envoi`. Ils exigent maintenant `merci=1`, la confirmation visible et le
`noindex`.

**Ce qui reste à faire, et ne peut l'être qu'en ligne** : l'étape 18 du guide de déploiement. Trois
pièges y sont désormais écrits, dont le premier est créé par la correction ci-dessus :

- sur une installation restée en `development`, la confirmation s'affiche **sans qu'aucun e-mail ne
  parte** — contrôler `wp_get_environment_type()` avant de conclure quoi que ce soit ;
- le thème ne force aucun en-tête `From:`, l'envoi part donc de `wordpress@top-famille-pro.fr`,
  adresse inexistante sur un domaine neuf : regarder le dossier indésirables avant de déclarer une
  panne ;
- l'expéditeur et le destinataire ne sont pas sur le même domaine, ce qui rend l'alignement
  SPF/DKIM déterminant.

Un formulaire qui affiche sa confirmation sans qu'aucun e-mail n'arrive perd les demandes en
silence, et rien dans l'administration ne le signale. C'est le dernier verrou de l'objectif
commercial du site.

---

## 13. Ce qui reste, et à qui

**Validation humaine — dossier G28.** 110 comparaisons, trois volumes navigables hors ligne, toutes
au statut `À VALIDER`. Réponse attendue : `Validé`, ou `Refusé : page — défaut constaté`. Ce qui
n'est pas nommé est considéré comme non encore jugé, jamais comme accepté. Après validation
explicite seulement : `FIDÉLITÉ CLAUDE DESIGN VALIDÉE`.

Les captures du dossier restent valides malgré la fusion : les trois apports de la branche PR
(garde d'envoi, correctif d'outil FP11, numéro de version) **ne changent aucun rendu en
production** — la garde n'émet son marqueur qu'en `local` ou `development`.

**Décisions qui ne bloquent pas.** Chacune a un défaut sûr, et aucune n'empêche une mise en ligne :

| Décision | Défaut appliqué tant qu'elle manque |
|---|---|
| Citation attribuée à Audrey, à valider par l'intéressée | contenu provisoire marqué |
| Nombre d'avis Google et URL de la fiche | section masquée, jamais de lien `#` |
| Photo authentique d'Audrey | pastille neutre à initiale |
| Validation des 8 communes secondaires, une par une | `noindex,follow` |
| Textes des vrais témoignages | témoignages provisoires marqués `data-tfp-provisional`, aucune donnée structurée |

**Réglages d'hébergement.** Cache LiteSpeed et compression à configurer explicitement : sur
mutualisé Hostinger, les cibles Lighthouse ne s'atteignent pas sans cela — et les chiffres du §6
sont mesurés *avec*.

---

## 14. Non-régression

Tout est rejouable en quatre commandes :

```
bash tools/banc-local.sh                                    # banc en production
TFP_BASE_URL=http://localhost:8901 node tools/audit-target-size.mjs
node tools/banc-production.mjs &  && node tools/lighthouse.mjs
bash tools/banc-local.sh --development && TFP_BASE_URL=http://localhost:8901 npx playwright test
```

Trois pièges de banc, qui ont chacun coûté du temps et sont désormais outillés :

1. `wp option get siteurl` doit valoir **exactement** `http://localhost:8901`. Une valeur avec un
   chemin fait répondre 404 à la feuille de style : les pages restent servies, le HTML est correct,
   et **toutes** les mesures géométriques portent alors sur une page non stylée. Aucun code HTTP de
   page ne le signale. Le script de montage se termine par ce contrôle.
2. La suite fonctionnelle exige `development` ; les mesures de performance exigent `production`.
   Les hauteurs sont identiques dans les deux.
3. Une lenteur inexpliquée de la suite vient de processus Chromium résiduels, jamais du thème.
