# Mise en route — thème Top-Famille Pro

Ce document explique comment activer le thème une fois votre hébergement
WordPress en place, et liste les informations encore nécessaires avant
mise en production.

## 1. Installation

1. Copier `wp-content/themes/top-famille-pro/` dans le `wp-content/themes/`
   de votre installation WordPress.
2. Déposer les fichiers de police manquants — voir
   `wp-content/themes/top-famille-pro/assets/fonts/README.txt`.
3. Activer le thème dans Apparence > Thèmes.
4. Aller dans **Données commerciales** (nouveau menu d'admin) et renseigner :
   téléphone, e-mail, adresse du siège, zones prioritaires, et vérifier les
   tarifs (26 € HT/h par défaut, frais, majoration, indemnité km, délai devis).
5. Aller dans **Données commerciales > Photographies** et déposer les
   photos réelles disponibles (les autres resteront en placeholder visible
   jusqu'à ce qu'elles soient ajoutées — rien n'est présenté comme une
   photo réelle tant qu'aucune image n'est déposée).

## 2. Pages à créer (Réglages > Pages > Ajouter)

Le titre de chaque page doit être saisi **exactement** comme indiqué
ci-dessous : le thème l'utilise tel quel comme balise `<h1>`.

| Titre de la page (= H1) | Slug (URL) | Modèle de page à sélectionner |
|---|---|---|
| (libre, ex. « Accueil ») | — | Aucun — cette page devient la page d'accueil statique (Réglages > Lecture), `front-page.php` s'applique automatiquement |
| Nettoyage professionnel de bureaux en Bourgogne-Franche-Comté | `nettoyage-de-bureaux` | Par défaut (le fichier `page-nettoyage-de-bureaux.php` s'applique automatiquement au slug) |
| Nos tarifs | `tarifs` | Par défaut (`page-tarifs.php`) |
| Entreprise de nettoyage à Dijon | `entreprise-nettoyage-dijon` | Par défaut (`page-entreprise-nettoyage-dijon.php`) |
| Nos prestations de nettoyage professionnel | `prestations` | Par défaut (`page-prestations.php`) |
| Zones d'intervention en Bourgogne-Franche-Comté | `zones-intervention` | Par défaut (`page-zones-intervention.php`) |
| Comment fonctionne une prestation Top-Famille Pro | `fonctionnement` | Par défaut (`page-fonctionnement.php`) |
| À propos de Top-Famille Pro | `a-propos` | Par défaut (`page-a-propos.php`) |
| Demande de devis | `demande-de-devis` | Par défaut (`page-devis.php`) |

Étape supplémentaire : dans **Réglages > Lecture**, choisir « Une page
statique » et sélectionner la page « Accueil » comme page d'accueil.

Ensuite : créer le menu principal (Apparence > Menus) avec « Prestations »
en parent et les futures pages de prestation en enfants (le sous-menu
accessible du header s'affiche automatiquement dès qu'un élément a des
enfants). Assigner ce menu à l'emplacement « Menu principal », et un menu
simple à l'emplacement « Pied de page ».

## 3. FAQ et avis clients

- La FAQ des 4 pages de référence est pré-remplie automatiquement à la
  première visite du site (voir `inc/contenu-initial.php`) — modifiable
  ensuite dans le menu **FAQ** de l'admin.
- Aucun avis client n'est pré-rempli : à ajouter un par un dans le menu
  **Avis clients**, uniquement des avis authentiques avec autorisation de
  publication cochée. La section « Ce que disent nos clients » de l'accueil
  reste masquée tant qu'aucun avis n'est publié.

## 4. Informations encore manquantes

- Téléphone, e-mail, adresse exacte du siège à Saint-Apollinaire.
- Photos réelles (hero des 3 pages, bureaux, commerce, sanitaires, partie
  commune, matériel, cahier de liaison, portrait d'Audrey, Audrey en
  échange, présence humaine page Tarifs).
- Avis clients réels et autorisation de publication.
- Règle exacte d'application des 50 € HT de frais de mise en place
  (champ dédié, éditable dans Données commerciales — aucun calcul
  automatique ne l'intègre tant qu'elle n'est pas confirmée).
- Décision sur l'ajout d'un plugin SEO gratuit (Rank Math / SEOPress) :
  non installé pour l'instant, le thème gère nativement title / meta
  description / canonical / Open Graph / sitemap (natif WordPress).

## 5. Table de correspondance des URL (Wix → WordPress)

**Aucune redirection n'a été mise en place.** Cette table est à valider
avant toute création de redirections 301. La colonne « Ancienne URL » est
à compléter : je n'ai pas eu accès aux URL du site Wix actuel.

| Ancienne URL (Wix) | Nouvelle URL | Action | Redirection 301 |
|---|---|---|---|
| à compléter | `/` | À valider | Non posée |
| à compléter | `/prestations/` | À valider | Non posée |
| à compléter | `/nettoyage-de-bureaux/` | À valider | Non posée |
| à compléter | `/tarifs/` | À valider | Non posée |
| à compléter | `/zones-intervention/` | À valider | Non posée |
| à compléter | `/entreprise-nettoyage-dijon/` | À valider | Non posée |
| à compléter | `/fonctionnement/` | À valider | Non posée |
| à compléter | `/a-propos/` | À valider | Non posée |
| à compléter | `/demande-de-devis/` | À valider | Non posée |

Pour compléter cette table : fournir la liste des URL actuelles du site
Wix (export du plan du site, ou liste manuelle des pages existantes).
