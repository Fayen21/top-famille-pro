# Recette du devis et de l'export — 12 novembre 2026

Point de départ : `b8d3bef`, thème 0.15.0 (`site-navigable (3).zip`, `RAPPORT-PASSE-COMMERCIALE.md`).
Résultat : thème **0.15.1**, branche `claude/jolly-fermi-d5dryq`. Rien n'est fusionné dans `main` ni
déployé. Design, 53 pages, tarifs et contenus validés : inchangés.

## 1. Corrections apportées

### Prestation enregistrée dans le devis
**Constat.** Le serveur (`includes/quote-form.php`) écrivait dans l'e-mail à la fois « Type de
locaux » (choix du prospect) et « Prestation concernée », recopiée du champ caché `prestation`. Ce
champ était figé sur la page d'origine (« Nettoyage de bureaux » depuis Bureaux), et restait vide en
accès direct. Arrivé depuis Bureaux, un prospect qui choisissait Commerce envoyait donc une demande
contradictoire.

**Correction : une seule source de vérité, les derniers choix de l'étape 1.**
- `tfp_quote_types_locaux()` : une seule table (type → libellé → prestation), partagée par le
  gabarit et le traitement serveur.
- `tfp_quote_prestation_demandee()` : la prestation se déduit du type de locaux et du régime, par
  exemple « Nettoyage de commerces (entretien régulier) ». Le régime est respecté, sans être répété
  pour « Nettoyage ponctuel ».
- **Le serveur recalcule** la prestation à la réception. Le champ caché ne sert plus que de repli,
  si le type est inconnu.
- Le JavaScript tient le champ à jour à chaque changement, y compris après « Modifier l'étape 1 »,
  et une dernière fois juste avant l'envoi.
- La page d'origine reste une information distincte : un nouveau champ `prestation_origine` est
  rangé dans le « Contexte de la demande » de l'e-mail, sous « Prestation de la page d'origine ».
- **Même défaut corrigé sur le département.** Transmis par une page de zone, il était conservé même
  si le prospect saisissait une autre ville. Il est maintenant retiré dans ce cas, et rétabli si le
  prospect revient à la ville d'origine.

Fichiers : `includes/quote-form.php`, `page-demande-de-devis.php`, `src/js/quote-form.js`.

### Export de démonstration
- **Bouton désactivé après la confirmation simulée.** Le verrou anti-double-envoi du thème
  désactive le bouton au tour de boucle suivant, donc après la réactivation faite par la démo. La
  réactivation est maintenant différée après le verrou. On peut valider, modifier, puis valider de
  nouveau sans recharger. Le verrou du site réel n'est pas touché : `src/js/main.js` est inchangé.
- **Préremplissage hors ligne.** Sans PHP, le type de locaux et la prestation d'origine n'étaient
  pas repris de l'URL. Le script du formulaire le fait maintenant, comme le serveur, et seulement
  sur un champ vide.
- **`generatepress/style.css`.** Sur le banc, le fichier ne contient que l'en-tête du thème (aucune
  règle). Il n'est donc pas nécessaire au rendu, et sa référence est retirée du paquet navigable. Le
  paquet brut garde le HTML de WordPress tel quel.
- **Vérificateur de l'export renforcé.** Il lit désormais aussi les attributs entre apostrophes :
  c'est pour cela que l'oubli n'avait pas été signalé. Il contrôle aussi les liens internes et les
  ancres, et rejoue Bureaux → Commerce ainsi que la double validation.

Fichier : `tools/export-statique.mjs`.

## 2. Tests réussis

| Contrôle | Environnement | Résultat |
|---|---|---|
| Formulaire : suite fonctionnelle (dont 4 nouveaux tests : Bureaux → Commerce, accès direct, retour à l'étape 1, département) | banc `development` | **21/21** |
| Recette serveur `tools/recette-devis.mjs` : vrai chemin `admin-post` → `wp_mail()`, e-mail intercepté par un mu-plugin temporaire du banc, aucune expédition | banc `production` | **25/25 contrôles** |
| Export : 53 routes ouvertes hors ligne à 375 et 1440 px, 5 963 liens internes, ancres, ressources locales | fichiers locaux | 53/53, 0 ancre introuvable, 0 ressource manquante, 0 image cassée, 0 requête externe |
| Démonstration : notice, validation de l'étape 1, confirmation simulée, **2e validation après modification**, bouton actif, Bureaux → Commerce, 0 POST, 0 événement de conversion | export | OK |
| Paquets et parité dépôt ↔ livraison | — | 1 258 fichiers concordants |
| Suite Playwright complète | banc `development` | voir §4 |

Contenu de la recette serveur :
- **Accès direct** (Commerces, ponctuel, téléphone seul, surface et code postal vides) : demande
  acceptée. E-mail : « Prestation demandée : Nettoyage de commerces (intervention ponctuelle) », sans
  ligne e-mail, code postal ni surface.
- **Bureaux → Commerce** (régulier), e-mail seul, puis retour à l'étape 1 pour passer en
  ponctuel : l'e-mail porte le dernier choix. « Nettoyage de bureaux » n'y figure que comme
  prestation de la page d'origine. Le Reply-To renvoie vers le prospect.
- **Serveur seul juge** : un POST forcé avec une prestation périmée (« Nettoyage de bureaux ») et le
  type Commerces produit « Nettoyage de commerces ».
- **Sans téléphone ni e-mail** : refus annoncé, l'étape 1 reste affichée.
- **Accueil à 375 × 812** :
  - tarif « 27 € HT/h » entièrement visible (bas à 540 px) ;
  - « Demander mon devis » et « Appeler Top-Famille Pro » de 60 px de haut, entièrement visibles
    au-dessus de la barre mobile (qui commence à 731 px) ;
  - chaque bouton reçoit le clic en son centre ;
  - barre mobile affichée, avec Appeler et Demander mon devis à 60 px ;
  - aucun débordement horizontal.

Exemple d'e-mail produit (parcours Bureaux → Commerce, IP masquée) :

```
Objet : [Demande de devis] Recette B
Reply-To: Recette B <recette@example.com>

Nom : Recette B
E-mail : recette@example.com
Type de locaux : Commerces
Régime : Ponctuel
Prestation demandée : Nettoyage de commerces (intervention ponctuelle)

Message :
Recette du 12 novembre 2026 — demande de test, ne pas traiter.

--- Contexte de la demande ---
Page d'origine : http://localhost:8901/prestations/bureaux/
Prestation de la page d'origine : Nettoyage de bureaux
Référent : http://localhost:8901/prestations/bureaux/
IP : [banc]
```

## 3. Captures à 375 px

Elles sont dans `docs/captures-recette-devis/` :
- premier écran de l'accueil, à 375 × 812 ;
- devis en accès direct, étapes 1 et 2 ;
- devis depuis Bureaux avec Commerce, étapes 1 et 2 ;
- confirmation réelle (`?merci=1`) ;
- démo de l'export après la deuxième validation.

Les mesures sont dans `bilan.json`.

## 4. Suite complète

_Voir la section ajoutée en fin de recette._

## 5. Reste à valider en préproduction

- **Envoi réel non vérifié.** Aucune préproduction ni boîte de test n'est accessible depuis cette
  session. La recette prouve le contenu remis à `wp_mail()`, pas la remise par le transport
  d'Hostinger (SPF/DKIM, indésirables, adresse d'expédition : PROJECT_INPUTS, question ouverte
  n° 4). Il reste à faire un envoi contrôlé vers une boîte de test, puis à vérifier :
  - l'objet ;
  - le Reply-To ;
  - les lignes « Prestation demandée » et « Prestation de la page d'origine » ;
  - les accents.
- **Thème parent réel.** Le banc utilise un GeneratePress réduit à son en-tête. Le rendu avec le
  vrai thème parent est à contrôler en préproduction.
- **Photos.** Aucun visuel autorisé de hall résidentiel ni de remise en état n'est disponible. Le
  dépôt n'en contient pas, et Openverse et Wikimedia sont refusés par le réseau de la session.
  - Copropriétés garde le couloir, Ponctuel garde la scène partagée avec l'accueil.
  - Seule photo inutilisée du dépôt : `hero-nettoyage-vitres.jpg`, une personne nettoyant une
    fenêtre. Elle n'est pas retenue : 560 px de large pour un visuel affiché jusqu'à 1 000 px, et
    une licence non documentée.
