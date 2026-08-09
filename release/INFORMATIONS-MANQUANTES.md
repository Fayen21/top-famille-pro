# Informations encore manquantes — Top-Famille Pro

> État en phase 7. Les données d'immatriculation (SIRET, capital, APE, TVA, date
> d'immatriculation, incohérence sur le SIREN) sont **désormais confirmées** (extrait Pappers +
> complément client) et intégrées dans le site — voir `docs/RAPPORT-FINAL.md` et
> `PROJECT_INPUTS.md` §2. Ce document liste ce qui reste réellement à fournir.

## Ce qu'il reste à transmettre

| # | Donnée | Où elle sera utilisée | Bloque la mise en ligne ? |
|---|---|---|---|
| 1 | **Assurance RC professionnelle** — nom de l'assureur et numéro de police | Mentions légales | Oui — le site affirmait « nous sommes assurés » sur l'ancien site, à ne republier qu'une fois vérifié |
| 2 | **URL de la fiche Google Business** | Réglages « Réassurance & avis », lien vers l'avis en ligne | Non — la section reste masquée tant que non fournie |
| 3 | **Note Google réelle** | Idem | Non — idem |
| 4 | **Nombre d'avis réels** | Idem | Non — idem |
| 5 | **Texte exact des témoignages autorisés à republier** | Page Avis clients | Non — 6 noms de clients réels sont déjà connus (`PROJECT_INPUTS.md` §7 : Jean-Louis D., Anna P., Michel G., Laurent, Laura, Anne-Sophie), mais leur texte exact n'a jamais été transmis dans ce dépôt |
| 6 | **Portrait réel d'Audrey** (photo authentique) | Accueil, page « Pourquoi nous » | Non — une pastille neutre (initiale) remplace honnêtement la photo tant qu'elle n'est pas fournie |
| 7 | **Adresse de réception des demandes de devis** | Formulaire de devis (`wp_mail()`) | À vérifier au déploiement — le code envoie réellement, jamais testé bout en bout faute de transport mail en développement |
| 8 | **Choix `@top-famille-pro.fr` ou maintien `@top-famille.fr`** | Coordonnées affichées partout sur le site | Non — le site utilise actuellement `@top-famille.fr`, cohérent avec l'existant |
| 9 | **Validation des 8 communes secondaires**, une par une (Saint-Apollinaire, Chenôve, Quetigny, Talant, Longvic, Fontaine-lès-Dijon, Marsannay-la-Côte, Beaune) | Pages de zone correspondantes | Non — restent `noindex,follow` tant qu'aucune réponse n'est donnée ; ce n'est pas un blocage, juste un état par défaut sûr |
| 10 | **Décision sur `topentreprise.fr`** (redirection vers le nouveau site ou abandon) | Plan de redirections 301 | Non — le plan (`docs/REDIRECTIONS.md`) est prêt, mais pas appliqué tant que la décision n'est pas prise |
| 11 | **Inventaire des articles du blog de l'ancien site**, pour les redirections d'articles manquantes | Idem | Non — seules les redirections de pages confirmées figurent dans le plan actuel |
| 12 | **Confirmation que la grille tarifaire est toujours à jour** (24,30 € / 26,00 € / 30,00 € HT/h) | Toutes les pages tarifaires | Non — souhaitable avant mise en ligne, pas un blocage technique |

## Ce qui n'est plus manquant (phase 7)

Pour mémoire — ces informations étaient précédemment listées ici et sont désormais intégrées :

- ~~SIRET~~ — confirmé : `938 472 420 00018`
- ~~Code APE~~ — confirmé : `81.21Z` (Nettoyage courant des bâtiments)
- ~~Numéro de TVA intracommunautaire~~ — confirmé : `FR32 938 472 420`
- ~~Capital social~~ — confirmé : `600,00 €`
- ~~Date d'immatriculation~~ — confirmée : `16/12/2024`
- ~~Incohérence sur le SIREN~~ — levée : `938 472 420` (l'ancien site en publiait un autre,
  938 472 242, déjà identifié comme non conforme)

## Comment transmettre ces informations

Une fois disponibles, ces valeurs se saisissent :
- **Assurance, hébergeur complet** : directement dans `wp-content/themes/topfamillepro/page-mentions-legales.php` (remplacer les `[À COMPLÉTER]` restants), ou transmettre à l'équipe technique pour intégration.
- **Google Business, avis, portrait** : depuis l'administration WordPress, réglage « Réassurance & avis » et Personnaliser (Customizer) — aucune modification de code nécessaire, les emplacements sont déjà prêts à les recevoir.
- **Reste** : à transmettre à l'équipe technique pour intégration dans le code (adresse e-mail, choix de domaine, décisions de redirection).
