# Check-list de mise en ligne — Top-Famille Pro, thème 0.17.0

> Version du 18 novembre 2026. À suivre dans l'ordre, case par case. Une case ⛔ non cochée
> **arrête** la procédure : on ne passe pas à l'étape suivante.
>
> Fichiers à utiliser : dossier `release/paquets-passe-2026-11-17/`
> - `topfamillepro-theme.zip` — le thème (version 0.17.0, tarif 26 € HT/h) ;
> - `topfamillepro-content-installer.zip` — l'outil temporaire qui crée les 53 pages (version 1.11.0) ;
> - `SHA256SUMS.txt` — empreintes pour vérifier que les fichiers ne sont pas abîmés.
>
> **Raccourci** : les phases 2 et 4 peuvent être faites en une commande SSH avec
> `tools/deploiement/deployer-hostinger.sh` — mode d'emploi dans `DEPLOIEMENT-PAR-SCRIPT.md`.
>
> Le pas à pas détaillé, avec les écrans de l'administration, est dans `GUIDE-DEPLOIEMENT-HOSTINGER.md`
> (même dossier `release/`). Cette check-list le remplace sur deux points devenus faux : les
> 8 communes secondaires sont désormais **indexées** (et dans le sitemap), et les avis ne montrent
> plus d'état « avis à venir ».

---

## Phase 0 — Décisions à prendre avant tout (vous et Audrey)

- [ ] ⛔ **PR #10 relue et fusionnée dans `main`** par vous, sur GitHub, après validation visuelle
      du site navigable (`site-navigable.zip`).
- [ ] ⛔ **Avis clients** : ceux affichés viennent de la maquette et sont fictifs (38 pages).
      Choisir : (a) les remplacer par de vrais avis (les six de l'ancien site, ou de nouveaux),
      saisis dans **Réglages → Réassurance & avis** ; ou (b) les retirer avant l'ouverture.
      Publier de faux avis présentés comme vrais est une pratique commerciale trompeuse.
- [ ] ⛔ **Mentions légales relues** à l'écran sur la préproduction : SIRET, capital, RCS, TVA
      conformes au **Kbis** (CLAUDE.md §5.7).
- [ ] **Adresse de réception des devis** confirmée : `audrey.b@top-famille.fr` (sinon, demander la
      modification du thème avant l'installation).
- [ ] **Sort de `topentreprise.fr`** décidé : redirigé vers le nouveau site (17 redirections prêtes
      dans `docs/REDIRECTIONS.md`) ou abandonné.
- [ ] Accès vérifiés : hPanel Hostinger, administration WordPress de `top-famille-pro.fr`, compte
      Google (pour la Search Console).

## Phase 1 — Sauvegarde

- [ ] ⛔ **Sauvegarde complète** du site actuel (fichiers + base de données) :
      hPanel → **Sauvegardes** → créer une sauvegarde. Noter la date et l'heure.
- [ ] Noter le thème actuellement actif (Apparence → Thèmes) : c'est la voie de retour arrière.
      Au dernier audit, c'était `V1top-famille-pro`.

## Phase 2 — Préproduction (copie de test)

- [ ] hPanel → **Sites → Créer un environnement de préproduction** (ou sous-domaine
      `staging.top-famille-pro.fr` avec copie de la base).
- [ ] Sur la préproduction, **Apparence → Thèmes** : GeneratePress installé (thème parent).
- [ ] **Extensions** : ACF (gratuit) installé et activé.
- [ ] **Apparence → Thèmes → Ajouter → Téléverser** `topfamillepro-theme.zip` → Installer.
      **Ne pas activer encore.**
- [ ] **Extensions → Ajouter → Téléverser** `topfamillepro-content-installer.zip` → Installer → Activer.
- [ ] **Outils → Installation Top-Famille Pro** : lire le tableau « Contrôle préalable »
      (simulation, rien n'est encore écrit). Repérer les pages étrangères éventuelles de l'ancien
      thème — ne rien supprimer à ce stade.
- [ ] Cocher « J'ai sauvegardé le site », cliquer **Installer ou mettre à jour le contenu**.
- [ ] ⛔ Rapport d'installation : **aucune ligne ⛔**. Sinon, noter le message exact et s'arrêter.
- [ ] **Apparence → Thèmes → activer « Top-Famille Pro »**.
- [ ] **Réglages → Permaliens → Enregistrer** (sans rien changer) : reconstruit les adresses.
- [ ] Tester `/prestations/bureaux/` et `/zones-intervention/cote-dor/dijon/` : la page s'affiche,
      pas d'erreur 404.

## Phase 3 — Recette sur la préproduction

### Contenu et affichage
- [ ] Le tableau de l'installateur affiche **tout présent** (colonne « Manquant » vide).
- [ ] Le tarif affiché est **26 € HT/h** (accueil, Tarifs, une prestation, une ville) ; exemples
      217 / 321 / 529 € HT/mois sur la page Tarifs.
- [ ] Menus : un clic sur « Prestations » et « Zones d'intervention » ouvre les choix ; menu mobile
      (☰) sur téléphone.
- [ ] Contrôle visuel sur **ordinateur et téléphone** : accueil, une prestation, une ville, Tarifs,
      Demander mon devis, Contact, mentions légales. Comparer avec `captures-2026-11-17.zip`.
- [ ] Rendu avec le **vrai GeneratePress** : rien d'inattendu (marges, polices, couleurs).
      Le banc de test utilisait un parent réduit ; c'est le premier contrôle avec le vrai.
- [ ] Aucune page étrangère publiée (anciennes offres, pages d'essai) : **Pages** → filtrer
      « Publiées » ; mettre en brouillon tout ce qui n'appartient pas aux 53 pages
      (liste : `PAGES-A-CREER.md`).

### Formulaire de devis — le test qui compte le plus
- [ ] ⛔ L'installation est en environnement **production** : le code source de
      `/demande-de-devis/` ne doit **pas** contenir `data-tfp-mail-disabled`
      (ou `wp eval 'echo wp_get_environment_type();'` affiche `production`).
- [ ] Envoyer une demande de test (vos coordonnées, message « TEST — ne pas traiter ») depuis
      **Nettoyage de bureaux → Demander un devis**, en choisissant **Commerces** à l'étape 1.
- [ ] ⛔ La confirmation s'affiche **et** l'e-mail arrive **en boîte de réception** (pas en
      indésirables) dans les minutes qui suivent.
- [ ] Dans l'e-mail : objet « [Demande de devis] … », « Répondre » vise l'adresse saisie,
      « Prestation demandée : Nettoyage de commerces… », « Prestation de la page d'origine :
      Nettoyage de bureaux », accents corrects.
- [ ] Si l'e-mail n'arrive pas ou tombe en indésirables : installer **WP Mail SMTP** et le
      configurer avec une vraie adresse d'expédition du domaine (SPF/DKIM alignés), puis refaire
      le test.

### Performance
- [ ] **LiteSpeed Cache** installé et activé : cache des pages + compression.
- [ ] Ne **pas** activer le chargement différé du CSS principal dans LiteSpeed.
- [ ] Compression vérifiée (réponse `content-encoding: br` ou `gzip`) :
      `curl -s -o /dev/null -D - -H 'Accept-Encoding: br, gzip' https://<preprod>/wp-content/themes/topfamillepro/assets/dist/css/main.css | grep -i content-encoding`
- [ ] Purger tout le cache LiteSpeed, puis **Lighthouse mobile** (Chrome → Outils de
      développement → Lighthouse) sur l'accueil et une prestation : Performance ≥ 90,
      Accessibilité / Bonnes pratiques / SEO ≥ 95.

## Phase 4 — Mise en production

- [ ] ⛔ Toutes les cases ⛔ des phases 0 à 3 sont cochées.
- [ ] Nouvelle **sauvegarde** de la production juste avant (hPanel → Sauvegardes).
- [ ] Refaire sur `top-famille-pro.fr` les étapes de la phase 2 : GeneratePress, ACF, thème,
      installateur, simulation, installation, activation du thème, permaliens.
- [ ] Ne **pas supprimer** l'ancien thème (`V1top-famille-pro`) : le laisser désactivé quelques
      jours, c'est le retour arrière.
- [ ] Refaire le **test du formulaire de devis** en production (même contrôle que phase 3).
- [ ] Activer LiteSpeed Cache (mêmes réglages) et purger le cache.
- [ ] **Désactiver puis supprimer** l'extension « Top-Famille Pro — installation du contenu » :
      elle ne doit jamais rester active.
- [ ] Nouvelle **sauvegarde** : la première de la version en ligne.

## Phase 5 — Juste après l'ouverture

- [ ] HTTPS actif, certificat valide ; `http://` et `www.` redirigent vers
      `https://top-famille-pro.fr/`.
- [ ] `https://top-famille-pro.fr/wp-sitemap.xml` liste **53 adresses** : 18 pages, 6 prestations,
      26 zones (dont les 8 communes), 3 articles.
- [ ] `https://top-famille-pro.fr/robots.txt` contient la ligne `Sitemap: https://top-famille-pro.fr/wp-sitemap.xml`.
- [ ] Une adresse inventée (ex. `/page-qui-n-existe-pas/`) renvoie une vraie page 404.
- [ ] **Google Search Console** : ajouter la propriété `top-famille-pro.fr`, déclarer le sitemap.
- [ ] Si `topentreprise.fr` est redirigé : poser les 17 redirections 301 de
      `docs/REDIRECTIONS.md` et en tester trois (ex. `/menage` → `/nettoyage-professionnel/`).
- [ ] Prévenir Audrey : les demandes arrivent par e-mail, l'objet commence par
      « [Demande de devis] ».

## Phase 6 — La semaine suivante

- [ ] Une vraie demande reçue et traitée de bout en bout (ou nouveau test si aucune).
- [ ] Search Console : sitemap « Réussi », pas d'erreur d'indexation en hausse.
- [ ] Rien de cassé signalé → supprimer l'ancien thème `V1top-famille-pro`.
- [ ] Quand ils existent : URL de la fiche Google Business et nombre réel d'avis saisis dans
      **Réglages → Réassurance & avis** (la note n'apparaît qu'avec une URL de fiche valide).

---

## Retour arrière (si un problème grave apparaît)

1. **Apparence → Thèmes** : réactiver l'ancien thème (`V1top-famille-pro`). Le site revient à son
   état précédent ; les pages créées restent en base, sans effet.
2. Si cela ne suffit pas : hPanel → **Sauvegardes → Restaurer**, à la date de la phase 4.
3. Dans tous les cas, supprimer l'extension d'installation du contenu.
4. Noter précisément ce qui s'est passé (page, message, heure) avant de retenter.
