# Installation par script — Top-Famille Pro 0.18.1

> Version du 19 novembre 2026. Ce script remplace les **phases 2 et 4** de
> `CHECKLIST-MISE-EN-LIGNE.md` : installation des prérequis, du thème et du contenu, activation,
> permaliens, nettoyage, contrôles. Les **phases 0, 3, 5 et 6** restent à faire par une personne :
> décisions, test réel du devis, contrôle visuel, Search Console.
>
> Le script ne s'exécute que sur la commande de la personne qui le lance. Il demande de retaper
> l'adresse du site avant toute modification, et s'arrête au premier problème en expliquant quoi faire.

## 1. Préparer (une seule fois)

### a. Récupérer le fichier sur votre ordinateur

Un seul fichier suffit : **`tfp-livraison-0.18.1.zip`** (9 Mo). Deux façons de l'obtenir :
- la pièce jointe envoyée dans la conversation avec Claude ;
- ou GitHub, connecté à votre compte :
  https://github.com/fayen21/top-famille-pro/raw/claude/jolly-fermi-d5dryq/release/tfp-livraison-0.18.1.zip

**Ne le décompressez pas sur votre ordinateur** : il se décompresse sur le serveur (étape c).

Il contient le dossier `tfp-livraison/` avec quatre fichiers :
- le thème ;
- l'outil d'installation du contenu ;
- les empreintes de contrôle ;
- le script.

Son empreinte SHA-256 est :
`6e081c7ef51a1cc877ddabc7830ba378bdafcb910c57dc1271952edb3f9c1e19`.

### b. Activer l'accès SSH

1. hPanel → choisir le site → menu **Avancé → Accès SSH**.
2. Activer l'accès, puis définir ou changer le mot de passe SSH.
3. Noter la ligne de connexion affichée, de la forme `ssh -p 65002 u123456789@123.45.67.89`.

### c. Déposer et décompresser le fichier sur le serveur

1. hPanel → **Fichiers → Gestionnaire de fichiers**.
2. Remonter au **dossier personnel**, tout en haut de l'arborescence, celui qui contient le dossier
   `domains`. **Pas** dans `public_html` : ce dossier est public sur Internet.
3. Bouton **Téléverser** (flèche vers le haut) → choisir `tfp-livraison-0.18.1.zip`.
4. Clic droit sur le fichier → **Extraire** → confirmer. Un dossier `tfp-livraison` apparaît.
5. Le fichier `tfp-livraison-0.18.1.zip` peut ensuite être supprimé.

### d. Ouvrir le terminal

Deux possibilités :
- dans hPanel, sur la page **Accès SSH**, le bouton du **terminal dans le navigateur**, s'il est
  proposé ;
- depuis votre ordinateur (Terminal sur Mac, PowerShell sous Windows) : coller la ligne de
  connexion notée à l'étape b, puis saisir le mot de passe SSH. Le mot de passe ne s'affiche pas
  pendant la frappe, c'est normal.

### e. Vérifier les fichiers et trouver le dossier du site

```
ls ~/tfp-livraison
ls ~/domains/
ls ~/domains/top-famille-pro.fr/public_html/wp-config.php
```

- La première commande doit lister les quatre fichiers.
- La troisième doit répondre par le chemin du fichier, et non par « No such file ».
- La préproduction a son propre dossier, indiqué dans hPanel sur la page de l'environnement de
  préproduction (souvent un sous-dossier ou un sous-domaine de `~/domains/`).

## 2. Préproduction d'abord

Trouver d'abord le dossier de la préproduction (chaque ligne affichée est un WordPress) :

```
find ~/domains/top-famille-pro.fr -maxdepth 3 -name wp-config.php
```

- **Une seule ligne** (`…/public_html/wp-config.php`) : il n'existe pas encore de préproduction.
  La créer dans hPanel → **WordPress → Préproduction** (« Staging »), puis relancer la commande.
- **Deux lignes** : la préproduction est celle qui n'est pas `…/public_html/wp-config.php`
  (par exemple `…/public_html/staging/wp-config.php`).

Se placer dans ce dossier (le chemin affiché, **sans** `/wp-config.php`), puis lancer le script.
Exemple, à adapter au chemin réellement affiché :

```
cd ~/domains/top-famille-pro.fr/public_html/staging
bash ~/tfp-livraison/deployer-hostinger.sh --simulation
bash ~/tfp-livraison/deployer-hostinger.sh --litespeed
```

Si le `cd` répond « No such file or directory », ne pas lancer le script : vérifier le chemin.

- `--simulation` ne modifie rien. Il vérifie WP-CLI, PHP, l'intégrité des fichiers et la version, et
  indique si le formulaire enverra de vrais e-mails.
- La deuxième commande installe. Elle demande de **retaper l'adresse exacte du site** affichée,
  puis enchaîne les étapes 1 à 8 en environ une minute.

Ensuite, faire la **phase 3** de la check-list : envoyer un devis de test, regarder le site et
lancer Lighthouse.

## 3. Production

Après validation de la préproduction, et une **sauvegarde hPanel** faite juste avant :

```
cd ~/domains/top-famille-pro.fr/public_html
bash ~/tfp-livraison/deployer-hostinger.sh --simulation
bash ~/tfp-livraison/deployer-hostinger.sh --litespeed
```

Puis refaire le test du devis en production (check-list, phase 4), puis la phase 5.

**Une fois le site en ligne et vérifié**, supprimer le dossier `~/tfp-livraison` (Gestionnaire de
fichiers, clic droit → Supprimer). Garder `~/tfp-sauvegardes` quelques jours : il sert au retour
arrière.

## 4. Ce que fait le script

| Étape | Action | S'arrête si… |
|---|---|---|
| 0 | Contrôles : WP-CLI, WordPress, PHP ≥ 8, ZIP intacts (SHA-256), thème en 0.18.1, environnement | une condition manque |
| 1 | Export de la base et archive des thèmes et extensions dans `~/tfp-sauvegardes/` ; note du thème actif | l'export échoue (voir §5) |
| 2 | GeneratePress, ACF, et LiteSpeed Cache avec `--litespeed` | GeneratePress ne s'installe pas |
| 3 | Thème installé (non activé) ; outil d'installation du contenu installé et activé | une installation échoue |
| 4 | Simulation : pages présentes ou à créer, contenu étranger aux 53 pages (**rien n'est supprimé**) | — |
| 5 | Installation du contenu ; rapport dans `~/tfp-sauvegardes/` | une étape est en erreur : **le thème n'est pas activé** |
| 6 | Activation du thème, permaliens « Nom de l'article » si vides, règles d'adresses reconstruites | l'activation échoue |
| 7 | Outil d'installation supprimé, cache LiteSpeed purgé | — |
| 8 | Thème actif, accueil 200, **26 € HT/h** affiché et plus aucun 27 €, 5 pages clés en 200, formulaire en **envoi réel**, vraie 404, **53 adresses** au sitemap, `robots.txt`, `llms.txt`, compression | — (bilan en échec, avec la commande de retour arrière) |

Un **✓** indique un contrôle réussi. Un **!** signale une alerte à lire, qui ne bloque pas. Un
**✕** signale un échec.

## 5. Cas particuliers

- **Revérifier le site sans rien modifier** : `bash ~/tfp-livraison/deployer-hostinger.sh --controles`.
  Cette commande relance seulement les contrôles de l'étape 8. `--simulation` ne les fait pas.
- **Anciennes pages restées publiées** (le sitemap compte plus de 53 adresses) : les passer en
  brouillon et rediriger leur adresse en 301 vers la nouvelle page. Ne jamais toucher à la page
  définie comme page d'accueil (`wp option get page_on_front`). Pour top-famille-pro.fr, le
  19 novembre 2026, cela concernait :
  - `/fonctionnement/` → `/notre-fonctionnement/` ;
  - `/entreprise-nettoyage-dijon/` → `/zones-intervention/cote-dor/dijon/` ;
  - `/nettoyage-de-bureaux/` → `/prestations/bureaux/`.

  Les redirections sont en tête du fichier `.htaccess`.
- **Fichier `llms.txt` dans `public_html`** : il est créé par l'outil IA d'Hostinger et masque
  celui du thème. Le déplacer dans `~/tfp-sauvegardes/`, puis désactiver sa génération dans
  l'extension Hostinger si elle le recrée.

- **« export de la base impossible »** : faire une sauvegarde complète dans hPanel → Sauvegardes,
  puis relancer avec `--sauvegarde-hpanel-faite`.
- **« formulaire de devis en mode test »** : `wp-config.php` contient
  `WP_ENVIRONMENT_TYPE` à `local` ou `development`. Le retirer, ou le mettre à `production`, puis
  relancer. Sinon, aucun devis ne partira.
- **« ACF n'a pas pu être installé »** : le site fonctionne, mais les champs ne sont pas modifiables
  en administration. L'installer ensuite via Extensions → Ajouter.
- **« sans compression »** : LiteSpeed Cache → Cache → activer, puis Page Optimization →
  compression. Ne **pas** activer le chargement différé du CSS principal.
- **Contenu « HORS des 53 pages »** : anciennes pages de l'ancien thème. Les mettre en brouillon
  après avoir vérifié qu'elles ne servent plus.

## 6. Retour arrière

```
bash ~/tfp-livraison/deployer-hostinger.sh --retour-arriere
```

Cette commande réactive le thème noté avant l'installation (`~/tfp-sauvegardes/theme-avant.txt`),
supprime l'outil d'installation s'il reste, et purge le cache. Pour réimporter aussi la base :

```
bash ~/tfp-livraison/deployer-hostinger.sh --retour-arriere --restaurer-base=~/tfp-sauvegardes/base-AAAAMMJJ-HHMMSS.sql
```

En dernier recours : hPanel → Sauvegardes → Restaurer.

## 7. Essai réalisé avant livraison

Le script a été lancé sur le banc local : WordPress, SQLite, environnement `production`, avec les
ZIP de `paquets-passe-2026-11-18`.

- **Installation complète** : 16 étapes de contenu sur 16, puis 14 contrôles sur 14 (rejoué avec les paquets 0.18.1). Alertes
  attendues sur le banc : base SQLite non exportable, ACF et LiteSpeed absents (pas de réseau vers
  wordpress.org), pas de compression.
- **Chemins d'échec vérifiés** : chacun s'arrête proprement.
  - ZIP abîmé : arrêt à l'étape 0.
  - Mauvaise adresse retapée : arrêt, rien n'est modifié.
  - Dossier sans WordPress : arrêt.
  - Environnement `development` : alerte à l'étape 0, puis contrôle « formulaire » en échec.
  - Retour arrière : l'ancien thème est réactivé.
- **Non testé ici** : le vrai WP-CLI d'Hostinger, `wp db export` sur MySQL, l'installation d'ACF,
  de GeneratePress et de LiteSpeed depuis wordpress.org. D'où la préproduction d'abord.
